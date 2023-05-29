<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::orderBy('week')->paginate(5);
        return view('sale.index', [
            'sales' => $sales
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sale.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'week' => ['required','max:255','unique:'.Sale::class],
            'sale' => ['required']
        ]);

        $validateData['user_id'] = auth()->user()->id;

        Sale::create($validateData);
        return redirect('/sale');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        return view('sale.edit', [
            'sale' => $sale
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $validateData = $request->validate([
            'week' => 'required|max:255',
            'sale' => 'required'
        ]);

        $validateData['user_id'] = auth()->user()->id;
        Sale::where('id', $sale->id)->update($validateData);
        return redirect('/sale');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        Sale::destroy($sale->id);
        return redirect('/sale');
    }
}
