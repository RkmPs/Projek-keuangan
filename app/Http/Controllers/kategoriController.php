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

class kategoriController extends Controller
{
    public function create()
    {
        //
        $categories = Categories::where('user_id', Auth::id())->get();

        return Inertia::render('Kategori/Kategori', [
            'categories' => $categories
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $user_id = Auth::id();

        $request->validate([
            'name' => 'required|string',
            'type' => 'required'
        ]);

        Categories::create([
            'user_id' => $user_id,
            'name' => $request->name,
            'type' => $request->type
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $categories = Categories::findOrFail($id);

        return Inertia::render('Kategori/Update', [
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        $categories = Categories::findOrFail($id);

        $categories->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return Redirect::route('kategori');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $categories = Categories::findOrFail($id);

        $categories->delete();

        return Redirect::route('kategori');
    }
}
