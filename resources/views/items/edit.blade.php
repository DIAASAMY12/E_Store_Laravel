@extends('layouts.app')

@section('content')<h1>Edit Item</h1>
@include('partials._item_form', ['action' => route('items.update', $item), 'method' => 'PUT', 'brands' => $brands])
@endsection
