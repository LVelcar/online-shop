<?php

namespace App\Http\Controllers; 

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

    public function store(Request $request)
    {
        $rules = [
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:1000'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,unavailable']
        ];

        request()->validate($rules);

        if (request()->status == 'available' && request()->stock == 0) {
            return redirect()
                    ->back()
                    ->withInput(request()->all())
                    ->withErrors('If available, stock must be greater than 0');
        }

        session()->forget('error');

        $product = Product::create($request->all());
        
        return redirect()
                ->route('products')
                ->withSuccess("Product with ID {$product->id} created successfully");
    }

    public function show($product)
    {
        $product = Product::findOrFail($product);

        return view('products.show', ['product' => $product]);
    }

    public function edit($product)
    {
        return view('products.edit', ['product' => Product::findOrFail($product)]);
    }

    public function update($product)
    {
        $rules = [
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:1000'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,unavailable']
        ];

        request()->validate($rules);

        $product = Product::findOrFail($product);
        $product->update(request()->all());

        return redirect()
                ->route('products')
                ->withSuccess("Product with ID {$product->id} updated successfully");
    }
    
    public function destroy($product)
    {
        $product = Product::findOrFail($product);
        $product->delete();

        return redirect()
                ->route('products')
                ->withSuccess("Product with ID {$product->id} deleted successfully");
    }

}

