@extends('layouts.app')

@section('title', '優惠券管理')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-4">
        <h2 class="text-2xl font-bold">優惠券管理</h2>
        <p class="text-muted">管理所有優惠券，包括創建、編輯、啟用/停用和刪除</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>優惠券列表</h3>
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                添加新優惠券
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>優惠券代碼</th>
                        <th>類型</th>
                        <th>金額/折扣</th>
                        <th>最低消費</th>
                        <th>使用次數</th>
                        <th>有效期</th>
                        <th>狀態</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->id }}</td>
                        <td><strong>{{ $coupon->code }}</strong></td>
                        <td>
                            @if($coupon->type === 'percentage')
                                <span class="badge bg-info">百分比</span>
                            @else
                                <span class="badge bg-success">固定金額</span>
                            @endif
                        </td>
                        <td>
                            @if($coupon->type === 'percentage')
                                {{ $coupon->value }}%
                            @else
                                ¥{{ $coupon->value }}
                            @endif
                        </td>
                        <td>
                            {{ $coupon->min_order_amount ? '¥'.$coupon->min_order_amount : '無限制' }}
                        </td>
                        <td>{{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '無限' }}</td>
                        <td>
                            @if($coupon->valid_from || $coupon->valid_until)
                                <small>
                                    @if($coupon->valid_from)
                                        {{ $coupon->valid_from->format('Y-m-d') }}
                                    @endif
                                    ~
                                    @if($coupon->valid_until)
                                        {{ $coupon->valid_until->format('Y-m-d') }}
                                    @endif
                                </small>
                            @else
                                <span class="text-muted">永久有效</span>
                            @endif
                        </td>
                        <td>
                            @if($coupon->is_active)
                                <span class="badge bg-success">啟用</span>
                            @else
                                <span class="badge bg-secondary">停用</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" 
                               class="btn btn-sm btn-primary">
                                編輯
                            </a>
                            <form action="{{ route('admin.coupons.toggle', $coupon->id) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning">
                                    {{ $coupon->is_active ? '停用' : '啟用' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('確定要刪除此優惠券嗎？')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    刪除
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection