@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <h1>Create Product</h1>

        <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') ?? $product->title }}" required>
            </div>
            <div class="form-row">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control" value="{{ old('description') ?? $product->description }}" required>
            </div>
            <div class="form-row">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" min="1.00" step="0.01" value="{{ old('price') ?? $product->price }}" required>
            </div>
            <div class="form-row">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" min="0" value="{{ old('stock') ?? $product->stock }}" required>
            </div>  
            <div class="form-row mt-2">
                <label for="status">Status</label>
                <select name="status" id="status" class="custom-select" required>
                    <option {{ old('status') == 'available' ? 'selected' : ($product->status == 'available' ? 'selected' : ' ') }} value="available">Available</option>
                    <option {{ old('status') == 'unavailable' ? 'selected' : ($product->status == 'unavailable' ? 'selected' : '') }} value="unavailable">Unavailable</option>
                </select>
            </div>
            <div class="form-row mt-2">
                <button type="submit" class="btn btn-primary btn-lg">Edit product</button>
            </div>
        </form>
    </div>
@endsection
    