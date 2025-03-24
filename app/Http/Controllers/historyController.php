<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Categories;
use Inertia\Inertia;


class historyController extends Controller
{
    //

    public function index(Request $request)
    {
        $categories = Categories::where('user_id', Auth::id())->get();

        // Ambil tahun pertama transaksi user
        $earliest_year = Transaction::where('user_id', Auth::id())
        ->selectRaw('YEAR(MIN(created_at)) as year')
        ->value('year');

        // Generate array tahun dari tahun pertama transaksi hingga tahun sekarang
        $current_year = now()->year;
        $years = $earliest_year 
            ? range($earliest_year, $current_year)
            : [$current_year]; // Fallback jika tidak ada transaksi

        $query = Transaction::with('Categories')
        ->where('user_id', Auth::id());      //mengambil sesuai id

            //filter type transaksi
            if ($request->filled('type')){
                $query->where('type', $request->type);
            }

            //filter kategori
            if ($request->filled('categories_id')){
                $query->where('categories_id', $request->categories_id);
            }

            //filter bulan 1 untuk januari 2 untuk februari
            if ($request->filled('month')){
                $query->whereMonth('created_at', $request->month)
                //Default ke tahun berjalan jika tahun tidak diisi
                ->whereYear('created_at', $request->filled('year') 
              ? $request->year 
              : now()->year);
            }

            //filter tahun (ex: 2025)
            if($request->filled('year')){
                $query->whereYear('created_at', $request->year);
            }

            //mengatur sort by
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);


        $transaksi = $query->paginate(10)->withQueryString();

        return Inertia::render('Transaksi/history', [
            'historys' => $transaksi,
            'categories' => $categories,
            'years' => $years,
        ]);
    }
}
