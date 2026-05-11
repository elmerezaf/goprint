@extends('layouts.app')

@section('title', __('messages.order_details'))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="d-flex justify-content-between items-center mb-4">
        <h2 class="text-2xl font-bold">{{ __('messages.order_details') }}</h2>
        <a href="{{ route('admin.orders') }}" class="btn btn-secondary">{{ __('messages.back_to_orders') }}</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h3>{{ __('messages.order_info') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.order_number') }}</label>
                        <p class="form-control-plaintext">{{ $order->id }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.customer_name') }}</label>
                        <p class="form-control-plaintext">{{ $order->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.contact_phone') }}</label>
                        <p class="form-control-plaintext">{{ $order->phone }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.email') }}</label>
                        <p class="form-control-plaintext">{{ $order->email }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.product_type') }}</label>
                        <p class="form-control-plaintext">{{ $order->product }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.size') }}</label>
                        <p class="form-control-plaintext">{{ $order->size }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.material') }}</label>
                        <p class="form-control-plaintext">{{ $order->material }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.quantity') }}</label>
                        <p class="form-control-plaintext">{{ $order->quantity }} {{ __('messages.piece') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.order_amount') }}</label>
                        <p class="form-control-plaintext text-danger font-bold text-xl">HK$ {{ $order->price }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.uploaded_file') }}</label>
                        @if($order->file)
                        <p class="form-control-plaintext">
                            <a href="{{ asset('uploads/' . $order->file) }}" target="_blank">{{ $order->file }}</a>
                        </p>
                        @else
                        <p class="form-control-plaintext text-muted">{{ __('messages.no_file') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>{{ __('messages.status') }} {{ __('messages.management') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.update-status', $order->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('messages.current_status') }}</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>{{ __('messages.processing') }}</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>{{ __('messages.cancelled') }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">{{ __('messages.update_status') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
