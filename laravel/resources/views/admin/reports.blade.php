@extends('layouts.app')

@section('title', '數據統計報表')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-4">
        <h2 class="text-2xl font-bold">數據統計報表</h2>
        <p class="text-muted">查看系統各項數據統計信息</p>
    </div>

    <div class="row mb-6">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="text-4xl mb-2">📦</div>
                    <h3 class="card-title">總產品數</h3>
                    <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="text-4xl mb-2">📁</div>
                    <h3 class="card-title">總分類數</h3>
                    <p class="text-3xl font-bold">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="text-4xl mb-2">🛒</div>
                    <h3 class="card-title">總訂單數</h3>
                    <p class="text-3xl font-bold">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="text-4xl mb-2">💰</div>
                    <h3 class="card-title">總收入</h3>
                    <p class="text-3xl font-bold">¥{{ $totalRevenue }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-6">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>訂單狀態統計</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <div class="text-center">
                            <div class="w-24 h-24 rounded-full bg-warning d-flex items-center justify-center mx-auto mb-2">
                                <span class="text-3xl">⏳</span>
                            </div>
                            <p class="text-2xl font-bold">{{ $totalPendingOrders }}</p>
                            <p class="text-muted">待處理</p>
                        </div>
                        <div class="text-center">
                            <div class="w-24 h-24 rounded-full bg-success d-flex items-center justify-center mx-auto mb-2">
                                <span class="text-3xl">✅</span>
                            </div>
                            <p class="text-2xl font-bold">{{ $totalCompletedOrders }}</p>
                            <p class="text-muted">已完成</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>分類產品統計</h3>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        @foreach($categoryStats as $category)
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span>{{ $category->cat_name }}</span>
                                <span>{{ $category->products_count }} 件</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" 
                                     role="progressbar" 
                                     style="width: {{ $totalProducts > 0 ? ($category->products_count / $totalProducts) * 100 : 0 }}%"
                                     aria-valuenow="{{ $category->products_count }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="{{ $totalProducts }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>最近訂單</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>訂單編號</th>
                        <th>客戶</th>
                        <th>金額</th>
                        <th>狀態</th>
                        <th>創建時間</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->user->name ?? '未知' }}</td>
                        <td>¥{{ $order->total_amount }}</td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning">待處理</span>
                            @else
                                <span class="badge bg-success">已完成</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection