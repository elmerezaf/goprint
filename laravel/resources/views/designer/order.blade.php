@extends('layouts.app')

@section('title', '在线设计印刷 - ' . $product->pro_name)

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('designer.index') }}">在线设计</a></li>
                <li class="breadcrumb-item active">{{ $product->pro_name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-5">
                <div class="bg-light rounded-3 overflow-hidden position-relative" style="aspect-ratio: 1;" id="designPreview">
                    <canvas id="previewCanvas" style="width:100%;height:100%;"></canvas>
                </div>
            </div>
            <div class="col-lg-7">
                <h1 class="fw-bold mb-2">{{ $product->pro_name }}</h1>
                @if($product->category && isset($product->category->cat_name))
                    <p class="text-muted mb-3"><i class="fas fa-folder me-1"></i>{{ $product->category->cat_name }}</p>
                @endif
                <div class="mb-4">
                    <span class="fs-3 fw-bold text-warning">HK${{ number_format($product->pro_price, 0) }}</span>
                    <span class="text-muted ms-2">起</span>
                </div>
                <p class="mb-4" style="line-height: 1.8; font-size: 1.05rem;">{{ $product->pro_desc }}</p>

                <div class="mb-2 text-success">
                    <i class="fas fa-check-circle me-1"></i>可订购
                </div>
                <div class="mb-3 text-muted" style="font-size:13px;">
                    <i class="fas fa-paint-brush me-1"></i>此为您在线设计的个性化印刷品
                </div>

                <div class="d-flex gap-3 mt-4 flex-wrap align-items-center">
                    <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center gap-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->pro_id }}">
                        <input type="hidden" name="design_token" value="{{ $token }}">
                        <input type="hidden" name="product_name" value="{{ $product->pro_name }}">
                        <input type="hidden" name="product_price" value="{{ $product->pro_price }}">
                        <div class="input-group" style="width: 120px;">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="this.nextElementSibling.stepDown()">-</button>
                            <input type="number" name="quantity" value="1" min="1" max="9999" class="form-control text-center">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="this.previousElementSibling.stepUp()">+</button>
                        </div>
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fas fa-cart-plus me-2"></i>加入购物车
                        </button>
                    </form>
                    <a href="{{ route('designer.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-edit me-2"></i>重新设计
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js" crossorigin="anonymous"></script>
<script>
(function() {
    'use strict';

    var designData = @json($designData);
    var canvas = new fabric.StaticCanvas('previewCanvas');

    canvas.setWidth(600);
    canvas.setHeight(600);

    var front = designData.front || {};

    if (front.objects && front.objects.length > 0) {
        canvas.loadFromJSON(front, function() {
            canvas.renderAll();
            scaleCanvasToFit();
        });
    }

    function scaleCanvasToFit() {
        var container = document.getElementById('designPreview');
        if (!container) return;
        var maxW = container.clientWidth;
        var maxH = container.clientHeight;
        if (maxW <= 0 || maxH <= 0) return;
        var cw = canvas.width || 600;
        var ch = canvas.height || 360;
        var scale = Math.min(maxW / cw, maxH / ch, 1);
        canvas.setZoom(scale);
        canvas.setWidth(cw * scale);
        canvas.setHeight(ch * scale);
        canvas.renderAll();
    }

    window.addEventListener('resize', scaleCanvasToFit);
})();
</script>
@endsection