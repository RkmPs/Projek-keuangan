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
        $balance = AccountInfo::get('balance');

        //total pemasukan
        $totalIncome = Transaction::where('user_id', Auth::id())
            ->where('type', 'income')
            //untuk pemasukan perminggu
            ->when($request->has('this_week'), function($query){
                $query->whereBetween('created_at', [ 
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()]);
            })
            //untuk pemasukan perbulan
            ->when($request->has('this_month'), function($query, $month){
                $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
            })
            //untuk pemasukan pertahun
            ->when($request->has('this_year'), function($query, $year){
                $query->whereYear('created_at', Carbon:now()->year);
            })
            ->sum('amount');

        //total pengeluaran
        $totalExpense = Transaction::where('user_id', Auth::id())
            ->where('type', 'expense')
            //untuk pengeluaran perminggu
            ->when($request->has('this_week'), function($query){
                $query->whereBetween('created_at', [ 
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()]);
            })
            //untuk pemasukan perbulan
            ->when($request->month, function($query, $month){
                $query->whereMonth('created_at', $month);
            })
            //untuk pemasukan pertahun
            ->when($request->year, function($query, $year){
                $query->whereYear('created_at', $year);
            })
            ->sum('amount');

        //transaksi minggu ini

        $weekly  = Transaction::where('user_id', Auth::id())
            ->whereBetween('created_at', [ 
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()]);

        //transaksi bulan ini

        $montly = Transaction::where('user_id', Auth::id())
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year);

        //jumlah kategori 


        return Inertia::render('Dashboard', [
            'transaksi' => $transaksi,
            'balance' => $balance,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'weekly' => $weekly,
            'montly' => $montly,
        ]);
    }
}
