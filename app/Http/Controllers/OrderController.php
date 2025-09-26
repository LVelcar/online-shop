<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Iluminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('auth');
    }

    // Show the order confirmation view 
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

    // Create the order and redirect to payment
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $user = $request->user();

            // Create the order
            $order = $user->orders()->create([
                'status' => 'pending',
            ]);

            $cart = $this->cartService->getFromCookie();

            if (!$cart || $cart->products->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Your cart is empty!'
                ]);
            }

            // Prepare the products with quantity for attach
            $cartProductsWithQuantity = $cart->products->mapWithKeys(function ($product) {

                $quantity = $product->pivot->quantity;

                // Validate stock
                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'product' => "There is not enough stock for the quantity you required of {$product->title}",
                    ]);
                }

                // Reduce stock
                $product->decrement('stock', $quantity);

                // Prepare array for attach
                return [$product->id => ['quantity' => $quantity]];
            });

            // Asociate products to the order
            $order->products()->attach($cartProductsWithQuantity->toArray());

            // Opcional: clear the cart
            $cart->products()->detach();
            $cookie = $this->cartService->makeCookie($cart);

            // Redirect to payment
            return redirect()
                ->route('orders.payments.create', ['order' => $order->id])
                ->withCookie($cookie);
        }, 5);
    }
}