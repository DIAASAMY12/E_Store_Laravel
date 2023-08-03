@extends('layouts.app')

@section('content')
    <p># Low Quantity Alert</p>

    <p>Hello,{{$vendors->first_name}}</p>

    <p> This is a notification that the item "{{ $item->name }}" in your inventory is running low in quantity. Please
        take necessary actions to restock the item.
    </p>

    <p>Thank you for your attention.</p>

    <p>Best regards,</p>

@endsection

