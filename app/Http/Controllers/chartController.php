<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Models\Categories;
use Illuminate\Support\Carbon;

class chartController extends Controller
{
    // Menampilkan halaman chart
    public function testChart()
    {
        return Inertia::render('chart');
    }

    // **Data untuk Line Chart (Pemasukan & Pengeluaran Bulanan)**
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

    // **Data untuk Pie Chart (Total Dana per Kategori)**
    public function getPieChartData()
    {
        $transactions = Transaction::selectRaw('categories_id, SUM(amount) as total')
            ->where('user_id', Auth::id())
            ->where('type', 'Expense') // Hanya menampilkan pengeluaran
            ->groupBy('categories_id')
            ->get();

        $labels = [];
        $data = [];
        $backgroundColors = [];

        foreach ($transactions as $transaction) {
            $category = Categories::find($transaction->categories_id);
            if ($category) {
                $labels[] = $category->name;
                $data[] = $transaction->total;
                $backgroundColors[] = '#' . substr(md5(rand()), 0, 6); // Warna random untuk tiap kategori
            }
        }

        $pieChartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2
                ]
            ]
        ];

        return response()->json(['pieChartData' => $pieChartData]);
    }
}
