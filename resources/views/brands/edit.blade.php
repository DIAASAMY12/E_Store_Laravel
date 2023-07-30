@extends('layouts.app')

@section('content')<h1>Edit Brand</h1>
@include('partials._brand_form', ['action' => route('brands.update', $brand), 'method' => 'PUT'])
@endsection
