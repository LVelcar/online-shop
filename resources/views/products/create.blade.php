@extends('layouts.app')

@section('content')
    <div class="content container fluid">
        <h1>Create Product</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title')}}">
            </div>
            <div class="form-row">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control" value="{{ old('description')}}">
            </div>
            <div class="form-row">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" min="1.00" step="0.01" value="{{ old('price')}}">
            </div>
            <div class="form-row">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" min="0" value="{{ old('stock')}}">
            </div>  
            <div class="form-row mt-2 mb-2">
                <label for="status">Status</label>
                <select name="status" id="status" class="custom-select">
                    <option value="" selected>Select..</option>
                    <option {{ old('status') == 'available' ? 'selected' : '' }} value="available">Available</option>
                    <option {{ old('status') == 'unavailable' ? 'selected' : '' }} value="unavailable">Unavailable</option>
                </select>
            </div>
            <div class="form-row">
                <label for="">
                    {{ __('Images') }}
                </label>

                <div class="custom-file">
                    <input type="file" accept="image/*" name="images[]" class="custom-file-input" multiple>
                    <label class="custom-file-label">
                        Product images
                    </label>
                </div>
            </div>

            <div class="form-row">
                <button type="submit" class="btn btn-primary btn-lg">Create product</button>
            </div>
        </form>
    </div>
@endsection
    