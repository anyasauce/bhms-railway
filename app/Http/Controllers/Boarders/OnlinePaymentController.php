<?php

namespace App\Http\Controllers\Boarders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Boarder;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class OnlinePaymentController extends Controller
{
    public function index()
    {
        $user = auth()->guard('boarders')->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        $payments = Payment::where('boarder_id', $user->boarder_id)->get();
        $transactions = Transaction::where('boarder_id', $user->boarder_id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $payments = Payment::whereIn('status', ['pending', 'partial'])->get();
        return view('boarders.online-payment', compact('payments', 'transactions'));
    }

    public function process(Request $request)
    {
        return redirect()->route('boarders.online-payment')->with('success', 'Payment processed successfully.');
    }

    public function createPaymentLink($checkoutSessionId)
    {
        $payment = Payment::where('id', $checkoutSessionId)->first();
        if (!$payment) {
            return response()->json(['error' => 'Payment not found for this ID'], 404);
        }

        Log::info('Payment found:', ['id' => $payment->id]);

        $boarder = $payment->boarder;
        if (!$boarder) {
            return response()->json(['error' => 'Boarder not found for this payment'], 404);
        }

        if ($payment->amount < 100) {
            return response()->json(['error' => 'Amount must be at least 100 PHP'], 422);
        }

        try {
            $lineItems = [
                [
                    'currency' => 'PHP',
                    'amount' => (int) ($payment->amount * 100),
                    'name' => 'Payment for Room: ' . $payment->room_name,
                    'quantity' => 1,
                    'description' => $payment->description ?: 'Room payment',
                ]
            ];

            $successUrl = 'http://127.0.0.1:8000/online-payment/success?id=' . $checkoutSessionId;
            $cancelUrl = 'http://127.0.0.1:8000/online-payment/cancel?id=' . $checkoutSessionId;

            $data = [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'name' => $payment->first_name . ' ' . $payment->last_name,
                            'email' => $boarder->email ?? 'customer@example.com',
                            'phone' => $boarder->phone_number ?? ''
                        ],
                        'send_email_receipt' => true,
                        'show_description' => true,
                        'show_line_items' => true,
                        'payment_method_types' => ['gcash'],
                        'line_items' => $lineItems,
                        'success_url' => $successUrl,
                        'cancel_url' => $cancelUrl,
                        'description' => 'Payment Order #' . $payment->id . " of $boarder->first_name $boarder->last_name",
                        'metadata' => [
                            'order_id' => $payment->id
                        ],
                        'customer' => [
                            'name' => $payment->first_name . ' ' . $payment->last_name,
                            'email' => $boarder->email ?? 'customer@example.com',
                        ]
                    ]
                ]
            ];

            $secretKey = config('services.paymongo.secret_key');
            if (!$secretKey) {
                throw new \Exception('PayMongo secret key not configured');
            }

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($secretKey . ':')
            ])->post('https://api.paymongo.com/v1/checkout_sessions', $data);

            if ($response->successful()) {
                $checkoutSession = $response->json()['data'];

                $payment->update([
                    'checkout_session_id' => $checkoutSession['id'],
                    'status' => 'pending'
                ]);

                Log::info('Payment link created successfully', ['checkout_session_id' => $checkoutSession['id']]);

                return redirect($checkoutSession['attributes']['checkout_url']);
            }

            Log::error('PayMongo API Error:', [
                'status' => $response->status(),
                'response' => $response->json(),
                'request' => $data
            ]);

            return response()->json([
                'error' => 'Payment creation failed',
                'details' => $response->json()['errors'][0]['detail'] ?? 'Unknown error'
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('PayMongo Integration Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'An error occurred while processing the payment',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function verifyPaymentStatus($checkoutSessionId)
    {
        if (empty($checkoutSessionId)) {
            Log::error('Empty checkout_session_id provided');
            return false;
        }

        $secretKey = config('services.paymongo.secret_key');

        try {
            Log::info('Verifying payment with PayMongo:', [
                'checkout_session_id' => $checkoutSessionId
            ]);

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($secretKey . ':')
            ])->get('https://api.paymongo.com/v1/checkout_sessions/' . $checkoutSessionId);

            $responseData = $response->json();

            Log::info('PayMongo Response:', [
                'status_code' => $response->status(),
                'response_data' => $responseData
            ]);

            if ($response->successful()) {
                $data = $responseData['data'];
                $attributes = $data['attributes'] ?? [];

                $isPaid = false;

                if (isset($attributes['payment_intent']['status'])) {
                    $isPaid = $attributes['payment_intent']['status'] === 'succeeded';
                }

                if (isset($attributes['status'])) {
                    $isPaid = $isPaid || in_array($attributes['status'], ['paid', 'completed']);
                }

                Log::info('Payment Status Check:', [
                    'is_paid' => $isPaid,
                    'payment_intent_status' => $attributes['payment_intent']['status'] ?? 'not_found',
                    'session_status' => $attributes['status'] ?? 'not_found'
                ]);

                return $isPaid;
            }

            Log::error('PayMongo API Error:', [
                'status' => $response->status(),
                'error' => $responseData['errors'] ?? 'Unknown error'
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Payment Verification Error:', [
                'error' => $e->getMessage(),
                'checkout_session_id' => $checkoutSessionId
            ]);
            return false;
        }
    }

    public function handleSuccessfulPayment(Request $request)
    {
        Log::info('Received payment ID:', ['id' => $request->query('id')]);

        $paymentId = trim($request->query('id'));
        $payment = Payment::find($paymentId);

        Log::info('Payment found:', ['payment' => $payment]);

        if (!$payment) {
            return redirect()->route('frontend.payment.failed')->with('error', 'Payment not found');
        }

        $boarder = $payment->boarder;

        if (!$boarder) {
            return redirect()->route('frontend.payment.failed')->with('error', 'Boarder not found');
        }

        $boarder->balance = max(0, $boarder->balance - $payment->amount);
        $boarder->save();

        $payment->status = 'paid';
        $payment->save();

        Log::info('Payment successful and balance updated', [
            'payment_id' => $payment->id,
            'amount_paid' => $payment->amount,
            'new_balance' => $boarder->balance
        ]);

        $paymentMethodTypes = $payment->checkout_session->payment_method_types ?? ['gcash'];

        Transaction::create([
            'boarder_id' => $boarder->boarder_id,
            'type' => implode(', ', $paymentMethodTypes),
            'amount' => $payment->amount,
            'description' => 'Payment for boarder account balance',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('boarders.online-payment')->with('success', 'Payment updated successfully');
    }


    public function handleCancelledPayment(Request $request)
    {
        $user = auth()->guard('boarders')->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        $pendingPayment = Payment::where('boarder_id', $user->boarder_id)
            ->where('status', 'pending')
            ->first();

        return redirect()->route('boarders.online-payment')->with('error', 'Payment was cancelled.');
    }


}
