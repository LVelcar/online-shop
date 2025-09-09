@extends('layouts.app')


@section('content')
    <div class="content container ">
        <h1>Your cart</h1>
        @if(!isset($cart) || $cart->products->isEmpty())
            <div class="alert alert-warning">
                <h2>Your cart is empty</h2>
                <p>Please add some products to your cart.</p>
            </div>
        @else
        <h4 class="text-center">Your car total <strong> ${{ $cart->total }}</strong></h4>
            <a class="btn btn-success mb-1 m-3" href="{{ route('orders.create') }}">
                Start Order
            </a>
            <div class="row mb-3 container mt-3">
                @foreach ($cart->products as $product)
                    <div class="col-3 mb-3 mt-2">
                        <div class="card">
                            @include('components.product-card')
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection