<?php

namespace App\Http\Controllers;

use App\Models\Boarder;
use App\Models\Room;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
date_default_timezone_set('Asia/Manila');

class DashboardController extends Controller
{
    public function index()
    {
        $boardersCount = Boarder::count();
        $availableRooms = Room::where('status', 'available')->count();
        $boardersPerRoom = Boarder::groupBy('room_id')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyIncome = Payment::whereIn('status', ['paid'])
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthlyPartialIncome = Payment::whereIn('status', ['paid'])
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('partial_amount');

        $totalIncome = Payment::whereIn('status', ['paid'])
            ->sum('amount');

        $totalPartialRevenue = Payment::whereIn('status', ['partial'])
            ->sum('partial_amount');

        $totalBoarderBalance = Boarder::where('balance', '>', 0)
            ->sum('balance');

        return view('dashboard', compact(
            'monthlyIncome',
            'monthlyPartialIncome',
            'totalIncome',
            'totalPartialRevenue',
            'totalBoarderBalance',
            'boardersCount',
            'availableRooms',
            'boardersPerRoom',
            'pendingPayments'
        ));
    }

}
