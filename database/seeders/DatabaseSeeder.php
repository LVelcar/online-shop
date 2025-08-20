<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Cart;
use App\Models\Image;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        $users = User::factory(10)
            ->create()
            ->each(function ($user) {
                $image = Image::factory()
                  ->user()
                  ->make();
                  $user->image()->save($image);
            });

        // Crear órdenes con pagos asociados
        $orders = Order::factory(10)
            ->make()
            ->each(function ($order) use ($users) {
                // Asignar un usuario aleatorio como cliente
                $order->customer_id = $users->random()->id;
                $order->save();

                // Crear un pago asociado a la orden
                $payment = Payment::factory()->make();
                $order->payment()->save($payment);
            }) ;

        $carts = Cart::factory(10)->create();

        $products = Product::factory(10)
            ->create()
            ->each(function ($product) use ($orders, $carts) {
                $order = $orders->random();

                $order->products()->attach([
                    $product->id => [
                        'quantity' => mt_rand(1, 3)
                    ]
                ]);

                $cart = $carts->random();
                $cart->products()->attach([
                    $product->id => [
                        'quantity' => mt_rand(1, 3)
                    ]
                ]);

                $images = Image::factory(mt_rand(2, 4))->make();
                $product->images()->saveMany($images);
            });
    }
};