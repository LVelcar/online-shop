<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Services\CartService;

class ProductCartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(Request $request, Product $product)
    {
        // Obtener carrito desde el servicio
        $cart = $this->cartService->getFromCookieOrCreate();

        // Verificar si el producto ya está en el carrito
        $existingQuantity = $cart->products()
            ->where('product_id', $product->id)
            ->first()?->pivot?->quantity ?? 0;

        // Attach o actualizar pivot
        if ($existingQuantity > 0) {
            $cart->products()->updateExistingPivot($product->id, [
                'quantity' => $existingQuantity + 1,
            ]);
        } else {
            $cart->products()->attach($product->id, ['quantity' => 1]);
        }

        // Guardar carrito en cookie por 7 días
        $cookie = Cookie::make('cart', $cart->id, 7 * 24 * 60);

        return redirect()->back()->withCookie($cookie);
    }
}
