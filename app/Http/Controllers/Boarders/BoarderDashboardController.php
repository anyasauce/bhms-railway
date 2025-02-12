<?php

namespace App\Http\Controllers\Boarders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Boarders;
use App\Models\Payment;

class BoarderDashboardController extends Controller
{
    public function index()
    {
        $boarder = Auth::guard('boarders')->user();
        $balance = $boarder ? $boarder->balance : 0;

        $transactions = Payment::where('boarder_id', $boarder->boarder_id)
            ->orderBy('created_at', 'asc')
            ->get();

        $totalPaid = $transactions->where('status', 'paid')->sum('amount');
        $totalPartial = $transactions->where('status', 'partial')->sum('partial_amount');
        $totalDue = $transactions->whereIn('status', ['partial', 'pending'])->sum('amount');

        $upcomingPayments = Payment::where('boarder_id', $boarder->boarder_id)
            ->where('payment_due_date', '>', now()->setTimezone('Asia/Manila'))
            ->orderBy('payment_due_date', 'asc')
            ->get();

        return view('boarders.boarderdashboard', compact('upcomingPayments', 'balance', 'transactions', 'totalPaid', 'totalPartial', 'totalDue'));
    }


}
