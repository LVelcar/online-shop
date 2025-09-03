<div class="card h-100 d-flex flex-column">
    {{-- Imagen del producto --}}
    @if ($product->images->isNotEmpty())
        <img class="card-img-top" 
             src="{{ asset($product->images->first()->path) }}" 
             alt="{{ $product->title }}"
             style="height: 300px; object-fit: cover; width: 100%;">
    @else
        {{-- Imagen por defecto si no hay --}}
        <img class="card-img-top" 
             src="{{ asset('img/products/default.jpg') }}" 
             alt="Sin imagen"
             style="height: 300px; object-fit: cover; width: 100%;">
    @endif
        <h5 class="card-title">{{ $product->title }}</h5>
        <p class="card-text flex-grow-1">{{ $product->description }}</p>
        <h4 class="text-right"><strong>$ {{ $product->price }}</strong></h4>
        <p class="card-text"><strong>{{ $product->stock }} left</strong></p>
        <form 
            class="d-inline" 
            method="POST" 
            action="{{ route('products.carts.store', ['product' => $product->id]) }}">
            @csrf
            <button 
                type="submit" 
                class="btn btn-primary btn-block"
                @if ($product->stock === 0) disabled @endif>
                Add to Cart
            </button>
        </form>
</div>
