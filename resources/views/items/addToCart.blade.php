@extends('layouts.app')

@section('content')
    <h1>Items</h1>
    <ul>
        @foreach ($items as $item)
            <li>
{{--                <p style="font-size: 30px">{{ $item->name }}</p>--}}
                <form action="{{ route('cart.add', $item->id) }}" method="POST">
                    @csrf
                    <button type="submit">Add to Cart</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
