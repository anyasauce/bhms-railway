<?php

namespace App\Http\Controllers\Boarders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referral;
use Illuminate\Support\Facades\Auth;
use App\Models\Boarder;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
class ReferralController extends Controller
{
    public function index()
    {
        $boarder = Auth::guard('boarders')->user();

        if (!$boarder) {
            return redirect()->back()->with('error', 'No boarder profile found.');
        }

        $referredPeople = Referral::where('referrer_id', $boarder->boarder_id)
            ->with('application')
            ->get();

        $referralCode = Boarder::where('boarder_id', $boarder->boarder_id)->value('referral_code');

        $totalReferrals = $referredPeople->count();
        $totalPoints = $referredPeople->sum('points');

        return view('boarders.referral', compact('referralCode','boarder', 'referredPeople', 'totalReferrals', 'totalPoints'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);


        return redirect()->route('boarders.referral')->with('success', 'Referral sent successfully.');
    }

   public function redeemDiscount(Request $request)
{
    $user = auth()->guard('boarders')->user();

    if (!$user) {
        return redirect()->back()->with('error', 'You need to log in to redeem points.');
    }

    $totalPoints = Referral::where('referrer_id', $user->boarder_id)->sum('points');

    $pointsMapping = [
        10 => 100,
        20 => 200,
        40 => 300,
        50 => 400,
        60 => 500
    ];

    $requestedDiscount = (int) $request->discount;

    $pointsRequired = null;
    foreach ($pointsMapping as $points => $discountAmount) {
        if ($discountAmount === $requestedDiscount) {
            $pointsRequired = $points;
            break;
        }
    }

    if ($pointsRequired === null) {
        return redirect()->back()->with('error', 'Invalid discount selection.');
    }

    if ($totalPoints < $pointsRequired) {
        return redirect()->back()->with('error', 'Not enough points to redeem this discount.');
    }

    $pendingPayment = Payment::where('boarder_id', $user->boarder_id)
        ->where('status', 'pending')
        ->first();

    if (!$pendingPayment) {
        return redirect()->back()->with('error', 'No pending payments found.')->with('sweetalert', true);
    }

    if ($requestedDiscount > $user->balance) {
        return redirect()->back()->with('error', 'Discount amount cannot exceed your current balance.');
    }

    $newPaymentAmount = max(0, $pendingPayment->amount - $requestedDiscount);
    $newBalance = max(0, $user->balance - $requestedDiscount);

    $pendingPayment->amount = $newPaymentAmount;
    $pendingPayment->save();

    $user->balance = $newBalance;
    $user->save();

    $referrals = Referral::where('referrer_id', $user->boarder_id)
        ->orderBy('points', 'desc')
        ->get();

    $pointsToDeduct = $pointsRequired;

    foreach ($referrals as $referral) {
        if ($pointsToDeduct <= 0) break;

        if ($referral->points >= $pointsToDeduct) {
            $referral->points -= $pointsToDeduct;
            $referral->save();
            break;
        } else {
            $pointsToDeduct -= $referral->points;
            $referral->points = 0;
            $referral->save();
        }
    }

    return redirect()->back()->with('success', "You've redeemed ₱{$requestedDiscount} off your next payment!");
}

}
