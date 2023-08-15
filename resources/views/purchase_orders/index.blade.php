<!-- resources/views/purchase_orders/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Purchase Orders</h1>

    @if ($purchaseOrders->isEmpty())
        <p>No purchase orders found.</p>
    @else
        <table class="table mt-3">


            <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Purchase Time</th>
                {{--                <th>Action</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach ($purchaseOrders as $purchaseOrder)
                <tr>
                    <td>{{ $purchaseOrder->id }}</td>
                    <td>{{ $purchaseOrder->status }}</td>
                    <td>{{ $purchaseOrder->item->name }}</td>
                    {{--                    <td>--}}
                    {{--                        @foreach ($cartItems as $cartItem)--}}
                    {{--                            <li>--}}
                    {{--                                (Quantity: {{ $cartItem['quantity'] }})--}}
                    {{--                            </li>--}}
                    {{--                        @endforeach--}}
                    {{--                    </td>--}}


                    <td>
                        @foreach ($cartItems as $cartItem)
                            @if ($cartItem['item_id']===$purchaseOrder->item_id)
                                (Quantity: {{ $cartItem['quantity'] }})
                            @else
                            @endif
                        @endforeach
                    </td>

                    <td>{{ $purchaseOrder->created_at }}</td>
                    {{--                    <td>--}}
                    {{--                        <a href="{{ route('purchase_orders.edit', $purchaseOrder) }}">Edit</a>--}}
                    {{--                        <!-- Add delete link if needed -->--}}
                    {{--                    </td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
        <form action="{{ route('purchase_orders.destroy') }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">Purchase</button>
        </form>
    @endif
@endsection
