<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('auth');
    }

    // Mostrar la vista de confirmación de la orden
    public function create()
    {
        $cart = $this->cartService->getFromCookie();

        if (!$cart || $cart->products->isEmpty()) {
            return redirect()
                ->back()
                ->withErrors("Your cart is empty!");
        }

        return view('orders.create')->with([
            'cart' => $cart,
        ]);
    }

    // Crear la orden y redirigir al formulario de pago
    public function store(Request $request)
    {
        return DB::transaction(function ()  use ($request) {
        
            $user = $request->user();

            $order = $user->orders()->create([
                'status' => 'pending',
            ]);

            $cart = $this->cartService->getFromCookie();

            $cartProductsWithQuantity = $cart
                ->products
                ->mapWithKeys(function ($product) {
                    return [
                        $product->id => ['quantity' => $product->pivot->quantity]
                    ];
                });

            $order->products()->attach($cartProductsWithQuantity->toArray());

            // Redirigimos al formulario de pago
            return redirect()
                ->route('orders.payments.create', ['order' => $order->id]);
        }, 5);
    }
}