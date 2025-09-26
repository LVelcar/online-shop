@extends('layouts.app')

@section('content')
    <div class="content container ">
        <h1>Welcome to the Product Management System</h1>
        @empty($products)
            <div class="alert alert-danger">
                <h2>No products available</h2>
                <p>Please add some products to the system.</p>
            </div>
        @else
            <div class="row mb-3 container mt-3">
                <!-- @dump($products) -->

                @foreach ($products as $product)
                    <div class="col-3 mb-3 mt-2">
                        <div class="card h-100 d-flex flex-column mb-3 mt-2">
                            @include('components.product-card')
                        </div>
                    </div>
                @endforeach

                <!-- @dump($products)
                @dump(\DB::getQueryLog()) -->
            </div>
        @endif
    </div>
@endsection