<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\Redirect;
Use App\Http\Controllers\id;
use Inertia\Inertia;
use App\Models\AccountInfo;
use App\Models\Transaction;
use App\Models\Categories;
use Illuminate\Support\Carbon;

class chartController extends Controller
{
    //

    public function testChart(){
        return Inertia::render('chart');
    }

    public function getChartData()
    {

        $transactions = Transaction::selectRaw('MONTH(created_at) as month, SUM(amount) as total, type')
            ->where('user_id', Auth::id())
            ->groupBy('month', 'type')
            ->orderBy('month')
            ->get();

        $labels = [];
        $incomeData = [];
        $expenseData = [];

        foreach (range(1, 12) as $month) {
            $labels[] = Carbon::create()->month($month)->translatedFormat('F'); // Nama bulan
            $incomeData[] = $transactions->where('month', $month)->where('type', 'Income')->sum('total');
            $expenseData[] = $transactions->where('month', $month)->where('type', 'Expense')->sum('total');
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => $incomeData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                    'tension' => 0.1
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $expenseData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                    'tension' => 0.1
                ]
            ]
        ];

        return response()->json(['chartData' => $chartData]);
    }

}
