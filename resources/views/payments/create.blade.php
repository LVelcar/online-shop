@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <h1 class="m-2">Payment Details</h1>

    <h4 class="text-center"><strong>Grand Total: </strong> ${{ $order->total }}</h4>

    <div class="text-center mt-4">
        <form method="POST" action="{{ route('orders.payments.store', ['order' => $order->id]) }}">
            @csrf
            <button type="submit" class="btn btn-success w-full py-2 rounded">
                Pay Now
            </button>
        </form>
    </div>
</div>
@endsection
