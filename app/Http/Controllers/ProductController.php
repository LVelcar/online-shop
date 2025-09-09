<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        // Solo los usuarios autenticados pueden crear, editar, eliminar
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Mostrar todos los productos.
     */
    public function index()
    {
        // Incluye productos soft deleted si es necesario con withTrashed()
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    /**
     * Mostrar formulario para crear producto.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Guardar un nuevo producto.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return redirect()
            ->route('products.index') // ruta correcta
            ->withSuccess("Product with ID {$product->id} created successfully");
    }

    /**
     * Mostrar un producto específico.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Mostrar formulario para editar producto.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Actualizar un producto.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()
            ->route('products.index')
            ->withSuccess("Product with ID {$product->id} updated successfully");
    }

    /**
     * Eliminar un producto (soft delete) y desvincular relaciones.
     */
    public function destroy(Product $product)
    {
        // Desvincular de carritos y pedidos para evitar problemas
        $product->carts()->detach();
        $product->orders()->detach();

        // Eliminar con soft delete
        $product->delete();

        return redirect()
            ->route('products.index')
            ->withSuccess("Product with ID {$product->id} deleted successfully");
    }
}
