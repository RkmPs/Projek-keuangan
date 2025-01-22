<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
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
        $query = Transaction::query();

        //mengambil sesuai id
        $query->where('user_id', auth()->user()->id());

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
            'transaksi' => $transaksi,
        ]);
    }


    public function index()
    {
        //
        $transaksi = Transaction::where('user_id', auth()->user()->id)->get();
        $balance = AccountInfo::get('balance');

        return Inertia::render('Dashboard', [
            'transaksi' => $transaksi,
            'balance' => $balance,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $kategori = Categories::where('user_id', auth()->user()->id)->get();
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
        $user_id = auth()->user()->id;
        $user = auth()->user();
        $account_info = $user->accountInfo;

        //validasi request
        $request->validate([
            'categories_id' => 'require|numeric',
            'amount' => 'require|numeric',
            'type' => 'require',
            'description' => 'require|text',
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
        if($transaksi->type == 'income'){
            $account_info += $transaksi->amount;
        }elseif($transaksi->type == 'expense'){
            $account_info -= $transaksi->amount;
        }

        $account_info->save();

        if($transaksi){
            return Redirect::route('transaksi.store')->with('message', 'success'); //belum diubah biar redirect yang bener
        } 
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $kategori = Categories::where('user_id', auth()->user()->id)->get();
        return Inertia::render('transaksi/edit', [
            'kategori' => $kategori,
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
            'description' => 'text',
        ]);

        $transaksi = Transaction::update([
            'categories_id' => $request->categories_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        //update balance accountInfo
        $user = auth()->user();
        $account_info = $user->accountInfo;

        if($transaksi->type == 'income'){
            $account_info += $transaksi->amount;
        }elseif($transaksi->type == 'expense'){
            $account_info -= $transaksi->amount;
        }

        $account_info->save();

        if($transaksi){
            return Redirect::route('transaksi.index')->with('message', 'success'); //belum diubah biar redirect yang bener
        } 

    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $transaksi = Transaksi::findOrFail();

        $user = auth()->user();
        $account_info = user()->accountInfo;

        //mengubah balance jika transaksi dihapus
        if ($transaction->type === 'income') {
            $account_info->balance -= $transaction->amount;
        } elseif ($transaction->type === 'expense') {
            $account_info->balance += $transaction->amount;
        }
        $account_info->save();
        
        $transaksi->delete();
        return Redirect::route('transaksi.index')->with('message','success');
    }
}
