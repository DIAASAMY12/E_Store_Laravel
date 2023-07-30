@extends('layouts.app')

@section('content')
    <h1>Cart</h1>
    @if (count($cartItems) > 0)
        <ul>
            @foreach ($cartItems as $cartItem)
                <li>
                    {{ $cartItem['name'] }} (Quantity: {{ $cartItem['quantity'] }})
                    (Create: {{ $cartItem['created_at'] }})
                </li>
            @endforeach
        </ul>
        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            <button type="submit">Clear Cart</button>
        </form>
    @else
        <p>Cart is empty.</p>
    @endif
@endsection
