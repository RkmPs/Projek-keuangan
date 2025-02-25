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
                $query->where('created_at', $request->month);
            }

            //filter tahun (ex: 2025)
            if($request->filled('year')){
                $query->where('created_at', $request->year);
            }

            //mengatur sort by
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);


        $transaksi = $query->paginate(10)->withQueryString();

        return Inertia::render('Transaksi/history', [
            'historys' => $transaksi,
            'categories' => $categories,
        ]);
    }
}
