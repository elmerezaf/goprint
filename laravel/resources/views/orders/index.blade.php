@extends('layouts.app')

@section('title', __('messages.my_orders'))

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="mb-6">{{ __('messages.my_orders') }}</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(count($orders) > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('messages.order_number') }}</th>
                                <th>{{ __('messages.product') }}</th>
                                <th>{{ __('messages.quantity') }}</th>
                                <th>{{ __('messages.price') }}</th>
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.order_date') }}</th>
                                <th>{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->product }}</td>
                                    <td>{{ $order->quantity }} {{ __('messages.piece') }}</td>
                                    <td>HK${{ number_format($order->price, 2) }}</td>
                                    <td>
                                        @if($order->status === 'pending')
                                            <span class="badge bg-warning">{{ __('messages.pending') }}</span>
                                        @elseif($order->status === 'paid')
                                            <span class="badge bg-success">{{ __('messages.paid') }}</span>
                                        @elseif($order->status === 'processing')
                                            <span class="badge bg-info">{{ __('messages.processing') }}</span>
                                        @elseif($order->status === 'completed')
                                            <span class="badge bg-primary">{{ __('messages.completed') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">{{ __('messages.view_details') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-12">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-xl mb-2">{{ __('messages.no_orders_yet') }}</h3>
                <p class="text-muted mb-4">{{ __('messages.go_shopping') }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">{{ __('messages.go_shopping') }}</a>
            </div>
        </div>
    @endif
</div>
@endsection
