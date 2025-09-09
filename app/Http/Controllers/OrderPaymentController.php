<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\CartService;

class OrderPaymentController extends Controller
{
    public $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('auth');
    }

    // Mostrar formulario de pago
    public function create(Order $order)
    {
        return view('payments.create')->with([
            'order' => $order,
        ]);
    }

    // Procesar el pago
    public function store(Request $request, Order $order)
    {
        // Limpiar carrito
        $this->cartService->getFromCookie()->products()->detach();

        // Crear registro de pago
        $order->payment()->create([
            'amount' => $order->total,
            'payed_at' => now(),
        ]);

        // Actualizar estado de la orden
        $order->status = 'payed';
        $order->save();

        return redirect()
            ->route('main')
            ->withSuccess('Your order has been successfully placed!');
    }
}
