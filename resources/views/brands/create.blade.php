@extends('layouts.app')

@section('content')<h1>Create Brand</h1>
@include('partials._brand_form', ['action' => route('brands.store')])
@endsection
