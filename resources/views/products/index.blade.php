@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <h1>List of te products</h1>
        <a href="{{ route('products.create') }}" class="btn btn-success mt-1">Create</a>

        @empty( $products )
            <div class="alert alert-danger" role="alert">
                No products found.
            </div>
        @else
            <div class="table-responsive mt-2">
                <table class="table table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Tittle</th>
                            <th>Desciption</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->status }}</td>

                            <td class="d-flex justify-content-around">
                                <a href="{{ route('products.show', ['product' => $product->id]) }}" class="btn btn-primary m-1">Show</a>
                                <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="btn btn-warning m-1">Edit</a>
                                <form class="d-inline m-1" action="{{ route('products.destroy', ['product' => $product->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endempty
    </div>
@endsection