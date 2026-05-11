@extends('layouts.app')

@section('title', '訂單確認')

@section('content')
<div class="container py-5">
    <div class="max-w-2xl mx-auto bg-white p-5 shadow rounded">
        <h2>訂單提交成功！</h2>

        <div class="alert alert-success mt-3">
            您的訂單已成功提交，請完成付款以確認訂單。
        </div>

        <h3 class="mt-5">訂單詳情</h3>
        <table class="table table-bordered mt-3">
            <tr>
                <td style="width: 35%;">訂單編號</td>
                <td>{{ $order->id }}</td>
            </tr>
            <tr>
                <td>客戶姓名</td>
                <td>{{ $order->name }}</td>
            </tr>
            <tr>
                <td>聯繫電話</td>
                <td>+852 {{ $order->phone }}</td>
            </tr>
            <tr>
                <td>電子郵箱</td>
                <td>{{ $order->email }}</td>
            </tr>
            <tr>
                <td>產品類型</td>
                <td>{{ $order->product }}</td>
            </tr>
            <tr>
                <td>尺寸</td>
                <td>{{ $order->size }}</td>
            </tr>
            <tr>
                <td>材質</td>
                <td>{{ $order->material }}</td>
            </tr>
            @if($order->printing_side)
            <tr>
                <td>印刷面</td>
                <td>{{ $order->printing_side }}</td>
            </tr>
            @endif
            @if($order->binding && $order->binding != '無')
            <tr>
                <td>裝訂方式</td>
                <td>{{ $order->binding }}</td>
            </tr>
            @endif
            <tr>
                <td>數量</td>
                <td>{{ $order->quantity }} 份</td>
            </tr>
            <tr>
                <td>上傳文件</td>
                <td>{{ $order->file ?? '未上傳' }}</td>
            </tr>
            <tr class="table-primary">
                <td><strong>訂單金額</strong></td>
                <td><strong>HKD {{ number_format($order->price, 2) }}</strong></td>
            </tr>
        </table>

        <div class="mt-5">
            <button id="payBtn" class="btn btn-warning text-white">立即付款</button>
            <a href="{{ route('order.create') }}" class="btn btn-secondary ml-2">繼續下單</a>
            <a href="{{ route('products.index') }}" class="btn btn-primary ml-2">瀏覽產品</a>
        </div>
    </div>
</div>

<script>
document.getElementById('payBtn').addEventListener('click', function() {
    this.disabled = true;
    this.innerHTML = '處理中...';

    fetch('{{ route('payment.create') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ order_id: {{ $order->id }} })
    })
    .then(response => response.json())
    .then(data => {
        if (data.url) {
            window.location.href = data.url;
        } else {
            alert('建立支付連結失敗');
            this.disabled = false;
            this.innerHTML = '立即付款';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('支付連結建立失敗，請稍後再試');
        this.disabled = false;
        this.innerHTML = '立即付款';
    });
});
</script>
@endsection
