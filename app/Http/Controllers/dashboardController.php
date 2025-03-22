<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Models\AccountInfo;
use Carbon\Carbon;
Use Illuminate\Support\Facades\Auth;


class dashboardController extends Controller
{
    //

    public function index(Request $request)
    {
        //
        $transaksi = Transaction::where('user_id', Auth::id());
        $balance = AccountInfo::where('user_id', Auth::id())->value('balance');

        $filterType = $request->input('filter', 'monthly');

        //total pemasukan
        $totalIncome = Transaction::where('user_id', Auth::id())
            ->where('type', 'income')
            //untuk pengeluaran perminggu
            ->when($filterType === 'weekly', function($query){
                $query->whereBetween('created_at', [ 
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()]);
            })
            //untuk pemasukan perbulan
            ->when($filterType === 'monthly', function($query){
                $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
            })
            ->sum('amount');

        //total pengeluaran
        $totalExpense = Transaction::where('user_id', Auth::id())
            ->where('type', 'expense')
            //untuk pengeluaran perminggu
            ->when($filterType === 'weekly', function($query) {
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
            })
            ->when($filterType === 'monthly', function($query) {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            })
            ->sum('amount');

        return Inertia::render('Dashboard', [
            'transaksi' => $transaksi,
            'balance' => $balance,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
        ]);
    }
}
