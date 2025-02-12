<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Boarder;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Manila');

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::whereIn('status', ['pending', 'partial'])->get();
        return view('payments.index', compact('payments'));
    }

    public function history()
    {
        $payments = Payment::all();
        return view('history', compact('payments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'boarder_id' => 'required|string|exists:boarders,boarder_id',
            'room_id' => 'required|string',
            'room_name' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'payment_due_date' => 'required|date',
        ]);

        $boarder = Boarder::where('boarder_id', $request->boarder_id)->first();
        if (!$boarder) {
            return redirect()->back()->with('error', 'Boarder not found.');
        }

        $existingPayment = Payment::where('boarder_id', $request->boarder_id)
            ->where('status', 'pending')
            ->where('created_at', '>=', now()->subDays(25))
            ->first();

        if ($existingPayment) {
            return redirect()->back()->with('error', 'You have already made a payment within the last 25 days. Please wait before making another payment.');
        }

        DB::beginTransaction();

        try {
            $payment = Payment::create([
                'boarder_id' => $request->boarder_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'room_id' => $request->room_id,
                'room_name' => $request->room_name,
                'amount' => $request->amount,
                'description' => $request->description,
                'payment_due_date' => $request->payment_due_date,
                'status' => 'pending',
            ]);

            $boarder->balance += $request->amount;
            $boarder->save();

            DB::commit();

            $this->sendPaymentConfirmationEmail(
                $request->first_name,
                $request->last_name,
                $request->amount,
                $request->payment_due_date,
                $request->room_name,
                $request->description,
                'pending',
            );

            return redirect()->back()->with('success', 'Payment saved and email sent successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    private function sendPaymentConfirmationEmail($first_name, $last_name, $amount, $dueDate, $roomName, $description, $status)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('josiahdanielle09gallenero@gmail.com', 'Admin');
            $mail->addAddress('josiahdanielle09gallenero@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'Payment Confirmation';
            $mail->Body = "
                <html>
                <head>
                    <style>
                        body {
                            font-family: 'Arial', sans-serif;
                            margin: 0;
                            padding: 0;
                            background-color: #f4f4f4;
                            width: 100%;
                            height: 100%;
                        }
                        .container {
                            width: 100%;
                            max-width: 600px;
                            margin: 0 auto;
                            background-color: #ffffff;
                            padding: 20px;
                            border-radius: 10px;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        }
                        .header {
                            text-align: center;
                            padding-bottom: 20px;
                        }
                        .header img {
                            width: 200px;
                            height: auto;
                            margin-bottom: 15px;
                        }
                        .content {
                            margin-top: 20px;
                            font-size: 16px;
                            line-height: 1.8;
                            color: #555;
                        }
                        .due-date {
                            font-size: 16px;
                            font-weight: bold;
                            color: #FF5722;
                            margin-top: 15px;
                        }
                        .footer {
                            text-align: center;
                            margin-top: 30px;
                            font-size: 14px;
                            color: #888;
                        }
                        .footer p {
                            margin: 5px 0;
                        }
                        .footer a {
                            color: #2e87d7;
                            text-decoration: none;
                        }
                        @media (max-width: 600px) {
                            .container {
                                padding: 15px;
                            }
                            .header img {
                                width: 180px;
                            }
                            .content {
                                font-size: 14px;
                            }
                            .due-date {
                                font-size: 14px;
                            }
                            .footer {
                                font-size: 12px;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <!-- You can place an image here if needed -->
                            <img src='logo.png' alt='Your Logo'>
                        </div>
                        <div class='content'>
                            <p>Dear <strong>{$first_name},</strong></p>
                            <p>Your payment of <b style='color: #4CAF50;'>₱{$amount}</b> has been successfully recorded.</p>
                            <p>The payment is due by: <span class='due-date'>{$dueDate}</span>.</p>
                            <p>Room Name: <strong>{$roomName}</strong></p>
                            <p>Description: {$description}</p>
                            <p>Status: <strong>{$status}</strong></p>
                            <p>Thank you for your payment!</p>
                        </div>
                        <div class='footer'>
                            <p>Note: This is a system-generated email. Please do not reply to this email.</p>
                            <p>Best regards, <br> Your Support Team</p>
                        </div>
                    </div>
                </body>
                </html>
                ";

            $mail->send();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function partialPayment(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        $validated = $request->validate([
            'partialAmount' => 'required|numeric|min:0|max:' . ($payment->amount - $payment->partial_amount),
        ]);

        $amount = $request->input('partialAmount');

        if ($amount <= 0 || $amount > ($payment->amount - $payment->partial_amount)) {
            return redirect()->back()->with('error', 'Invalid payment amount.');
        }

        $payment->partial_amount += $amount;

        if ($payment->partial_amount >= $payment->amount) {
            $payment->status = 'paid';
        } else {
            $payment->status = 'partial';
        }

        $payment->save();

        $boarder = Boarder::where('room_id', $payment->room_id)->first();
        if ($boarder) {
            $boarder->balance -= $amount;
            $boarder->save();
        }

        $this->sendPartialPaymentConfirmationEmail($payment->first_name, $amount, $payment->payment_due_date, $payment->room_name, $payment->description, $payment->status, $boarder->balance);

        return redirect()->route('payments.index')->with('success', 'Partial payment processed successfully.');
    }

    private function sendPartialPaymentConfirmationEmail($first_name, $amount, $dueDate, $roomName, $description, $status, $remainingBalance)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'josiahdanielle09gallenero@gmail.com';
            $mail->Password = 'idvq gvjg pzsa rvbi';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('josiahdanielle09gallenero@gmail.com', 'Admin');
            $mail->addAddress('josiahdanielle09gallenero@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'Payment Successfully';
            $mail->Body = "
                <html>
                <head>
                    <style>
                        body {
                            font-family: 'Arial', sans-serif;
                            margin: 0;
                            padding: 0;
                            background-color: #f4f4f4;
                            width: 100%;
                            height: 100%;
                        }
                        .container {
                            width: 100%;
                            max-width: 600px;
                            margin: 0 auto;
                            background-color: #ffffff;
                            padding: 20px;
                            border-radius: 10px;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        }
                        .header {
                            text-align: center;
                            padding-bottom: 20px;
                        }
                        .header img {
                            width: 200px;
                            height: auto;
                            margin-bottom: 15px;
                        }
                        .content {
                            margin-top: 20px;
                            font-size: 16px;
                            line-height: 1.8;
                            color: #555;
                        }
                        .due-date {
                            font-size: 16px;
                            font-weight: bold;
                            color: #FF5722;
                            margin-top: 15px;
                        }
                        .footer {
                            text-align: center;
                            margin-top: 30px;
                            font-size: 14px;
                            color: #888;
                        }
                        .footer p {
                            margin: 5px 0;
                        }
                        .footer a {
                            color: #2e87d7;
                            text-decoration: none;
                        }
                        /* Media Query for Mobile */
                        @media (max-width: 600px) {
                            .container {
                                padding: 15px;
                            }
                            .header img {
                                width: 180px;
                            }
                            .content {
                                font-size: 14px;
                            }
                            .due-date {
                                font-size: 14px;
                            }
                            .footer {
                                font-size: 12px;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <!-- You can place an image here if needed -->
                            <img src='logo.png' alt='Your Logo'>
                        </div>
                        <div class='content'>
                            <p>Dear <strong>{$first_name},</strong></p>
                            <p>Your payment of <b style='color: #4CAF50;'>₱{$amount}</b> has been successfully recorded.</p>
                            <p>The payment was due by: <span class='due-date'>{$dueDate}</span>.</p>
                            <p>Room Name: <strong>{$roomName}</strong></p>
                            <p>Description: {$description}</p>
                            <p>Status: <strong>{$status}</strong></p>
                            <p>Remaining Balance: <strong style='color: #f44336;'>₱{$remainingBalance}</strong></p>
                            <p>Thank you for your payment!</p>
                        </div>
                        <div class='footer'>
                            <p>Note: This is a system-generated email. Please do not reply to this email.</p>
                            <p>Best regards, <br> Your Support Team</p>
                        </div>
                    </div>
                </body>
                </html>
                ";

            $mail->send();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    public function delete($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment deleted.');
    }
}
