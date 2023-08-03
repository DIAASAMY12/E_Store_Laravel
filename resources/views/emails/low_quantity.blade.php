@extends('layouts.app')

@section('content')
<p>This is a notification that the item "{{ $item->name }}" in your inventory is running low in quantity. Please take necessary actions to restock the item.</p>
<p>Thank you for your attention.</p>

@endsection

