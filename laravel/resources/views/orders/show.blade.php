@extends('layouts.app')

@section('title', __('messages.order_details'))

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="mb-6">{{ __('messages.order_details') }}</h1>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4 class="text-primary">📋 {{ __('messages.order_info') }}</h4>
                    <p><strong>{{ __('messages.order_number') }}：</strong>#{{ $order->id }}</p>
                    <p><strong>{{ __('messages.order_date') }}：</strong>{{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                    <p><strong>{{ __('messages.status') }}：</strong>
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
                    </p>
                </div>
                <div class="col-md-6">
                    <h4 class="text-primary">👤 {{ __('messages.contact_info') }}</h4>
                    <p><strong>{{ __('messages.name') }}：</strong>{{ $order->name }}</p>
                    <p><strong>{{ __('messages.phone') }}：</strong>{{ $order->phone }}</p>
                    <p><strong>{{ __('messages.email') }}：</strong>{{ $order->email }}</p>
                </div>
            </div>

            <div class="border-top pt-4">
                <h4 class="text-primary">🎁 {{ __('messages.product_info') }}</h4>
                <table class="table table-bordered mt-3">
                    <tr>
                        <td>{{ __('messages.product_type') }}</td>
                        <td>{{ $order->product }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('messages.size') }}</td>
                        <td>{{ $order->size }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('messages.material') }}</td>
                        <td>{{ $order->material }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('messages.quantity') }}</td>
                        <td>{{ $order->quantity }} {{ __('messages.piece') }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('messages.uploaded_file') }}</td>
                        <td>{{ $order->file ?? __('messages.no_file') }}</td>
                    </tr>
                    <tr class="table-primary">
                        <td>{{ __('messages.order_amount') }}</td>
                        <td><strong>HK${{ number_format($order->price, 2) }}</strong></td>
                    </tr>
                </table>
            </div>

            @if($order->status === 'pending')
                <div class="mt-4 p-4 bg-warning bg-opacity-10 rounded">
                    <p class="text-warning"><strong>⚠️ {{ __('messages.reminder') }}：</strong>{{ __('messages.order_not_paid') }}</p>
                    <a href="{{ route('order.create') }}" class="btn btn-primary mt-2">{{ __('messages.continue_shopping') }}</a>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">{{ __('messages.back_to_orders') }}</a>
    </div>
</div>
@endsection
