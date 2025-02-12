<?php

namespace App\Http\Controllers\Boarders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
class BoarderPaymentController extends Controller
{
    public function history()
    {
        $boarderId = Auth::guard('boarders')->user()->boarder_id;

        $payments = Payment::where('boarder_id', $boarderId)->orderBy('created_at', 'desc')->get();

        return view('boarders.payments-history', compact('payments'));
    }
}
