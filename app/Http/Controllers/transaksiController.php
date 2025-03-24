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
use Illuminate\Validation\Rule;

class transaksiController extends Controller
{

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
        $account_info = AccountInfo::where('user_id', $user_id)->first();

        //validasi request
        $request->validate([
            'categories_id' => ['required', Rule::exists('categories', 'id')->where('type', $request->type)], //memastikan tipe kategori sama dengan tipe transaksi
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
