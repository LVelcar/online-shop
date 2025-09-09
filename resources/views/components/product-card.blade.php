<!-- product-card.blade.php -->

<!-- Incluir CSS de Vite -->
@vite(['resources/css/app.css', 'resources/css/product-card.css'])

<div class="product-card card h-100 flex flex-col bg-white rounded-lg shadow-md overflow-hidden">
    {{-- Imagen del producto --}}
    @if ($product->images->isNotEmpty())
        <img class="product-card-img w-full h-72 object-cover"
             src="{{ asset($product->images->first()->path) }}"
             alt="{{ $product->title }}">
    @else
        <img class="product-card-img w-full h-72 object-cover"
             src="{{ asset('img/products/default.jpg') }}"
             alt="Sin imagen">
    @endif

    <div class="p-4 flex flex-col flex-grow">
        <h5 class="product-card-title text-lg font-semibold mb-2">{{ $product->title }}</h5>
        <p class="product-card-description text-gray-600 flex-grow mb-2">{{ $product->description }}</p>
        <h4 class="product-card-price text-right text-blue-600 font-bold mb-2">$ {{ $product->price }}</h4>
        <p class="product-card-stock text-gray-500 mb-2"><strong>{{ $product->stock }} left</strong></p>

        @if (isset($cart))
            <p class="product-card-cart-info text-gray-700 mb-2">
                <strong>{{ $product->pivot->quantity }} in your cart {{ $product->total }}</strong>
            </p>
            <form action="{{ route('products.carts.destroy', ['cart' => $cart->id, 'product' => $product->id]) }}" 
                  class="product-card-form mt-auto"
                  method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-red w-full py-2 rounded">
                    Remove from Cart
                </button>
            </form>
        @else
            <form class="product-card-form mt-auto" 
                  method="POST" 
                  action="{{ route('products.carts.store', ['product' => $product->id]) }}">
                @csrf
                <button type="submit" 
                        class="btn btn-blue w-full py-2 rounded"
                        @if ($product->stock === 0) disabled @endif>
                    Add to Cart
                </button>
            </form>
        @endif
    </div>
</div>
