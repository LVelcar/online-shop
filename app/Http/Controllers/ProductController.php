<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    public function index()
    {
        $products = Product::all();

        return view('products.index', ['products' => $products]);
    }           

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        session()->forget('error');

        $product = Product::create($request->validated());
        
        return redirect()
                ->route('products')
                ->withSuccess("Product with ID {$product->id} created successfully");
    }

    public function show(Product $product)
    {
        // $product = Product::findOrFail($product);

        return view('products.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()
                ->route('products')
                ->withSuccess("Product with ID {$product->id} updated successfully");
    }
    
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
                ->route('products')
                ->withSuccess("Product with ID {$product->id} deleted successfully");
    }

}

