@extends('layouts.app')

@section('title', __('messages.order_management'))

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="d-flex justify-content-between items-center mb-4">
        <h2 class="text-2xl font-bold">{{ __('messages.order_management') }}</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">{{ __('messages.back_to_dashboard') }}</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>{{ __('messages.all_orders') }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('messages.order_number') }}</th>
                        <th>{{ __('messages.customer_name') }}</th>
                        <th>{{ __('messages.contact_phone') }}</th>
                        <th>{{ __('messages.product_type') }}</th>
                        <th>{{ __('messages.quantity') }}</th>
                        <th>{{ __('messages.price') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.created_at') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->product }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>HK$ {{ $order->price }}</td>
                        <td>
                            @if($order->status == 'pending')
                            <span class="badge bg-warning">{{ __('messages.pending') }}</span>
                            @elseif($order->status == 'processing')
                            <span class="badge bg-info">{{ __('messages.processing') }}</span>
                            @elseif($order->status == 'completed')
                            <span class="badge bg-success">{{ __('messages.completed') }}</span>
                            @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger">{{ __('messages.cancelled') }}</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.order-detail', $order->id) }}" class="btn btn-sm btn-primary">{{ __('messages.view') }}</a>
                            <form action="{{ route('admin.delete-order', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete_order') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($orders->isEmpty())
            <div class="text-center py-8 text-muted">
                <div class="text-4xl mb-2">📭</div>
                <p>{{ __('messages.no_orders') }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
