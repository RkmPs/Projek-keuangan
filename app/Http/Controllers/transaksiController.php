<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use App\Models\AccountInfo;
use App\Models\Transaction;
use App\Models\Categories;

class uangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $transaksi = Transaction::where('user_id', auth()->user()->id)->get();
        return Inertia::render('Dashboard', [
            'transaksi' => $transaksi,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $kategori = Categories::where('user_id', auth()->user()->id)->get();
        return Inertia::render('transaksi/create', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user_id = auth()->user()->id;

        $request->validate([
            'categories_id' => 'require|numeric',
            'amount' => 'require|numeric',
            'type' => 'require',
            'description' => 'require|text',
        ]);

        $transaksi = Transaction::create([
            'user_id' => $user_id,
            'categories_id' => $request->categories_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
        ]);

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
        $transaksi->delete();
        return Redirect::route('transaksi.index')->with('message','success');
    }
}
