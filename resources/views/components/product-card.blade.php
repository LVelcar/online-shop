<div class="card h-100 d-flex flex-column">
    {{-- Imagen del producto --}}
    @if ($product->images->isNotEmpty())
        <img class="card-img-top ml-2 mr-2 mt-2" 
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
        <h5 class="card-title m-2">{{ $product->title }}</h5>
        <p class="card-text flex-grow-1 mx-2">{{ $product->description }}</p>
        <h4 class="text-right mx-2 mb-2"><strong>$ {{ $product->price }}</strong></h4>
        <p class="card-text m-2"><strong>{{ $product->stock }} left</strong></p>

        @if (isset($cart))
            <p class="card-text m-2"><strong>{{ $product->pivot->quantity }} in your cart
                {{ $product->total }}
            </strong></p>
            <form action="{{ route('products.carts.destroy', ['cart' => $cart->id, 'product' => $product->id]) }}" 
                class="d-inlne mt-auto"
                method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-block m-2">
                    Remove from Cart
                </button>
        </form>
        @else
            <form 
                class="d-inline mt-auto" 
                method="POST" 
                action="{{ route('products.carts.store', ['product' => $product->id]) }}">
                @csrf
                <button 
                    type="submit" 
                    class="btn btn-primary btn-block m-2"
                    @if ($product->stock === 0) disabled @endif>
                    Add to Cart
                </button>
            </form>
        @endif
</div>
