@extends('layouts.app')

@section('content')<h1>Create Item</h1>
@include('partials._item_form', ['action' => route('items.store'), 'brands' => $brands])
@endsection
