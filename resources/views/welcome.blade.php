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
                @foreach ($products as $product)
                    <div class="col-3 mb-3 mt-2">
                        <div class="card">
                            @include('components.product-card')
                            <div class="details container mb-3 align-items-center">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection