<?php

namespace App\Http\Controllers\Panel;

use App\Http\Requests\ProductRequest;
use App\Models\PanelProduct;
use App\Http\Controllers\Controller;
use App\Scopes\AvailableScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Mostrar todos los productos.
     */
    public function index()
    {
        /** // Incluye productos soft deleted si es necesario con withTrashed()
        * $products = Product::all();
        *
        * return view('products.index', compact('products'));
        */
        return view('products.index')->with([
            'products' => PanelProduct::without('images')->get(),
        ]);
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
        $product = PanelProduct::create($request->validated());

        foreach ($request->images as $image) {
            $product->images()->create([
                'path' => 'images/' . $image->store('products', 'images'),
            ]);
        }

        return redirect()
            ->route('products.index') // ruta correcta
            ->withSuccess("Product with ID {$product->id} created successfully");
    }

    /**
     * Mostrar un producto específico.
     */
    public function show(PanelProduct $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Mostrar formulario para editar producto.
     */
    public function edit(PanelProduct $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Actualizar un producto.
     */
    public function update(ProductRequest $request, PanelProduct $product)
    {
        $product->update($request->validated());

        if ($request->hasFile('images')) {
            foreach ($product->images as $image) {
               $path = storage_path("app/public/{$image->path}");

               File::delete($path);

                $image->delete();
            }

            foreach ($request->images as $image) {
                $product->images()->create([
                    'path' => 'images/' . $image->store('products', 'images'),
                ]);
            }
        }

         

        return redirect()
            ->route('products.index')
            ->withSuccess("Product with ID {$product->id} updated successfully");
    }

    /**
     * Eliminar un producto (soft delete) y desvincular relaciones.
     */
    public function destroy(PanelProduct $product)
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
