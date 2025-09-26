<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;


class ProductCartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(Request $request, Product $product)
    {
        // Get cart from cookie or create new one
        $cart = $this->cartService->getFromCookieOrCreate();

        // View existing quantity in cart
        $existingQuantity = $cart->products()
            ->where('product_id', $product->id)
            ->first()?->pivot?->quantity ?? 0;

        // Validate stock
        if ($product->stock < $existingQuantity + 1) {
            throw ValidationException::withMessages([
                'product' => "There is not enough stock for the quantity you required of 
                {$product->title}",
            ]);
        }

        // Attach or update pivot table
        if ($existingQuantity > 0) {
            $cart->products()->updateExistingPivot($product->id, [
                'quantity' => $existingQuantity + 1,
            ]);
        } else {
            $cart->products()->attach($product->id, ['quantity' => 1]);
        }

        $cookie = $this->cartService->makeCookie($cart);

        return redirect()->back()->withCookie($cookie);
    }

    public function destroy(Product $product, Cart $cart)
    {
        $cart->products()->detach($product->id);

        $cookie = $this->cartService->makeCookie($cart);

        return redirect()->back()->withCookie($cookie);
    }
}
