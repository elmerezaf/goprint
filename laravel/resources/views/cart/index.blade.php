@extends('layouts.app')

@section('title', __('messages.shopping_cart'))

@section('content')
<div id="cart-root" data-cart-items='@json($products, JSON_HEX_APOS)'></div>
@endsection

@section('scripts')
@vite('resources/js/cart-ts/index.tsx')
@endsection
