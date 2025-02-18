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

class transaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function history(Request $request)
    {
        $query = Transaction::with('Categories')
        ->where('user_id', Auth::id());      //mengambil sesuai id

            //filter type transaksi
            if ($request->has('type')){
                $query->where('type', $request->type);
            }

            //filter kategori
            if ($request->has('category_id')){
                $query->where('category_id', $request->category_id);
            }

            //filter bulan 1 untuk januari 2 untuk februari
            if ($request->has('month')){
                $query->where('created_at', $request->month);
            }

            //filter tahun (ex: 2025)
            if($request->has('year')){
                $query->where('created_at', $request->year);
            }

            //mengatur sort by
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);


        $transaksi = $query->get();

        return Inertia::render('Transaksi/history', [
            'historys' => $transaksi,
        ]);
    }


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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $kategori = Categories::where('user_id', Auth::id())->get();
        return Inertia::render('Transaksi/create', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //mengambil data user
        $user_id = Auth::id();
        $account_info = AccountInfo::where('user_id', $user_id);

        //validasi request
        $request->validate([
            'categories_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'type' => 'required',
            'description' => 'required|string',
        ]);

        //menyimpan transaksi
        $transaksi = Transaction::create([
            'user_id' => $user_id,
            'categories_id' => $request->categories_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        //update balance accountInfo
        if($transaksi->type == 'Income'){
            $account_info->balance += $transaksi->amount;
        }elseif($transaksi->type == 'Expense'){
            $account_info->balance -= $transaksi->amount;
        }

        $account_info->save();

        if($transaksi){
            return Redirect::route('dashboard')->with('message', 'success'); 
        } 

        
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $transaksi = Transaction::findOrFail($id);
        $kategori = Categories::where('user_id', Auth::id())->get();

        return Inertia::render('Transaksi/edit', [
            'kategori' => $kategori,
            'transaksi' => $transaksi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

       
        $request->validate([
            'categories_id' => 'numeric',
            'amount' => 'numeric',
            'description' => 'string',
        ]);

        $transaksi = Transaction::findOrFail($id);

        $transaksi->update([
            'categories_id' => $request->categories_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        //update balance accountInfo
        $user_id = Auth::id();
        $account_info = AccountInfo::where('user_id', $user_id)->first();

        if($transaksi->type == 'Income'){
            $account_info->balance += $transaksi->amount;
        }elseif($transaksi->type == 'Expense'){
            $account_info->balance -= $transaksi->amount;
        }

        $account_info->save();

        if($transaksi){
            return Redirect::route('transaksi.history')->with('message', 'success'); //belum diubah biar redirect yang bener
        } 

    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $transaction = Transaction::findOrFail($id);

        $user_id = Auth::id();
        $account_info = AccountInfo::where('user_id', $user_id)->first();

        //mengubah balance jika transaksi dihapus
        if ($transaction->type === 'Income') {
            $account_info->balance -= $transaction->amount;
        } elseif ($transaction->type === 'Expense') {
            $account_info->balance += $transaction->amount;
        }
        $account_info->save();
        
        $transaction->delete();
        return Redirect::route('transaksi.history')->with('message','success');
    }
}
