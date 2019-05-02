<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Bitacora;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());

        $bitacora = new Bitacora();
        $hora = idate('H')-4;
        $minuto = idate('i');
        $segundo= idate('s');
        $reloj = $hora.":".$minuto.":".$segundo;
        $fecha = date('d-m-Y ');
        $tiempo = date($reloj);
        $bitacora->fecha = $fecha.$tiempo;
        $bitacora->usuario = Auth::user()->name;
        $bitacora->accion = 'Insertar Producto';
        $bitacora->save();

        return redirect()->route('products.edit', $product->id)
            ->with('info', 'Producto guardado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        $bitacora = new Bitacora();
        $hora = idate('H')-4;
        $minuto = idate('i');
        $segundo= idate('s');
        $reloj = $hora.":".$minuto.":".$segundo;
        $fecha = date('d-m-Y ');
        $tiempo = date($reloj);
        $bitacora->fecha = $fecha.$tiempo;
        $bitacora->usuario = Auth::user()->name;
        $bitacora->accion = 'Editar Producto';
        $bitacora->save();

        return redirect()->route('products.edit', $product->id)
            ->with('info', 'Producto actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        $bitacora = new Bitacora();
        $hora = idate('H')-4;
        $minuto = idate('i');
        $segundo= idate('s');
        $reloj = $hora.":".$minuto.":".$segundo;
        $fecha = date('d-m-Y ');
        $tiempo = date($reloj);
        $bitacora->fecha = $fecha.$tiempo;
        $bitacora->usuario = Auth::user()->name;
        $bitacora->accion = 'Eliminar Producto';
        $bitacora->save();

        return back()->with('info', 'Eliminado correctamente');
    }
}
