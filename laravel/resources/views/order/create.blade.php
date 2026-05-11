@extends('layouts.app')

@section('title', '立即下單')

@section('content')
<div class="container py-5">
    <div class="max-w-3xl mx-auto bg-white px-10 py-8 shadow-lg rounded-xl">
        <h2 class="mb-6 text-xl font-bold">印刷下單 & 自動報價</h2>

        <div id="pricePreview" class="alert alert-info mb-5 d-none">
            <strong>預計價格：</strong> <span id="previewPrice">HKD 0.00</span>
            <br><small id="discountInfo"></small>
        </div>

        <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">姓名 <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="請輸入您的姓名">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">電子郵箱 <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="example@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">聯繫電話 <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">+852</span>
                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="8位數字" maxlength="8" pattern="[0-9]{8}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">選擇產品 <span class="text-danger">*</span></label>
                    <select name="product" id="product" class="form-select @error('product') is-invalid @enderror" required>
                        <option value="">請選擇產品</option>
                        @foreach($products as $p)
                            <option value="{{ $p->pro_name }}" data-price="{{ $p->pro_price }}" {{ old('product') == $p->pro_name ? 'selected' : '' }}>{{ $p->pro_name }}</option>
                        @endforeach
                    </select>
                    @error('product')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">尺寸 <span class="text-danger">*</span></label>
                    <select name="size" id="size" class="form-select @error('size') is-invalid @enderror" required>
                        <option value="">請選擇尺寸</option>
                        <option value="A6" {{ old('size') == 'A6' ? 'selected' : '' }}>A6 (105×148mm)</option>
                        <option value="A5" {{ old('size') == 'A5' ? 'selected' : '' }}>A5 (148×210mm)</option>
                        <option value="A4" {{ old('size') == 'A4' ? 'selected' : '' }}>A4 (210×297mm)</option>
                        <option value="A3" {{ old('size') == 'A3' ? 'selected' : '' }}>A3 (297×420mm)</option>
                        <option value="A2" {{ old('size') == 'A2' ? 'selected' : '' }}>A2 (420×594mm)</option>
                        <option value="A1" {{ old('size') == 'A1' ? 'selected' : '' }}>A1 (594×841mm)</option>
                        <option value="DL" {{ old('size') == 'DL' ? 'selected' : '' }}>DL (110×220mm)</option>
                        <option value="自訂" {{ old('size') == '自訂' ? 'selected' : '' }}>自訂尺寸</option>
                    </select>
                    @error('size')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">材質 <span class="text-danger">*</span></label>
                    <select name="material" id="material" class="form-select @error('material') is-invalid @enderror" required>
                        <option value="">請選擇材質</option>
                        <option value="128g銅版" {{ old('material') == '128g銅版' ? 'selected' : '' }}>128g銅版紙</option>
                        <option value="157g銅版" {{ old('material') == '157g銅版' ? 'selected' : '' }}>157g銅版紙</option>
                        <option value="200g啞粉" {{ old('material') == '200g啞粉' ? 'selected' : '' }}>200g啞粉紙</option>
                        <option value="250g白卡" {{ old('material') == '250g白卡' ? 'selected' : '' }}>250g白卡紙</option>
                        <option value="300g銅版" {{ old('material') == '300g銅版' ? 'selected' : '' }}>300g銅版紙</option>
                        <option value="PVC防水" {{ old('material') == 'PVC防水' ? 'selected' : '' }}>PVC防水物料</option>
                        <option value="PP防水紙" {{ old('material') == 'PP防水紙' ? 'selected' : '' }}>PP防水紙</option>
                        <option value="防水帆布" {{ old('material') == '防水帆布' ? 'selected' : '' }}>防水帆布</option>
                        <option value="牛皮紙" {{ old('material') == '牛皮紙' ? 'selected' : '' }}>牛皮紙</option>
                        <option value="80g書紙" {{ old('material') == '80g書紙' ? 'selected' : '' }}>80g書紙</option>
                    </select>
                    @error('material')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">印刷面 <span class="text-danger">*</span></label>
                    <select name="printing_side" id="printing_side" class="form-select @error('printing_side') is-invalid @enderror" required>
                        <option value="單面" {{ old('printing_side') == '單面' ? 'selected' : '' }}>單面印刷</option>
                        <option value="雙面" {{ old('printing_side') == '雙面' ? 'selected' : '' }}>雙面印刷</option>
                    </select>
                    @error('printing_side')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">裝訂方式</label>
                    <select name="binding" id="binding" class="form-select @error('binding') is-invalid @enderror">
                        <option value="無" {{ old('binding') == '無' ? 'selected' : '' }}>無裝訂</option>
                        <option value="騎馬釘" {{ old('binding') == '騎馬釘' ? 'selected' : '' }}>騎馬釘</option>
                        <option value="膠裝" {{ old('binding') == '膠裝' ? 'selected' : '' }}>膠裝</option>
                        <option value="精裝" {{ old('binding') == '精裝' ? 'selected' : '' }}>精裝</option>
                        <option value="線圈裝" {{ old('binding') == '線圈裝' ? 'selected' : '' }}>線圈裝</option>
                    </select>
                    @error('binding')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">印刷數量 <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" min="1" step="1" required placeholder="請輸入正整數">
                    <small class="text-muted">數量需為正整數，大量印刷享更多折扣</small>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">上傳設計文件</label>
                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png,.ai,.psd">
                <small class="text-muted">支持格式：PDF, JPG, JPEG, PNG, AI, PSD（最大10MB）</small>
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">提交訂單</button>
            </div>
        </form>
    </div>
</div>

<script>
const priceMap = {
    @foreach($products as $p)
        "{{ $p->pro_name }}": {{ $p->pro_price }},
    @endforeach
};

const sizeMultiplier = {
    'A6': 0.6, 'A5': 0.8, 'A4': 1.0, 'A3': 1.5,
    'A2': 2.0, 'A1': 3.0, 'DL': 0.7, '自訂': 1.2
};

const materialMultiplier = {
    '128g銅版': 1.0, '157g銅版': 1.2, '200g啞粉': 1.3,
    '250g白卡': 1.5, '300g銅版': 1.6, 'PVC防水': 1.8,
    'PP防水紙': 1.4, '防水帆布': 2.0, '牛皮紙': 1.1, '80g書紙': 0.9
};

const bindingSurcharge = {
    '無': 0, '騎馬釘': 50, '膠裝': 120, '精裝': 300, '線圈裝': 80
};

function calculatePreview() {
    const product = document.getElementById('product').value;
    const size = document.getElementById('size').value;
    const material = document.getElementById('material').value;
    const side = document.getElementById('printing_side').value;
    const binding = document.getElementById('binding').value;
    const quantity = parseInt(document.getElementById('quantity').value) || 0;

    if (!product || !size || !material || quantity < 1) {
        document.getElementById('pricePreview').classList.add('d-none');
        return;
    }

    let basePrice = priceMap[product] || 100;
    let sMulti = sizeMultiplier[size] || 1.0;
    let mMulti = materialMultiplier[material] || 1.0;
    let sideMulti = side === '雙面' ? 1.8 : 1.0;
    let bindingCost = bindingSurcharge[binding] || 0;

    let unitPrice = basePrice * sMulti * mMulti * sideMulti;

    let discount = 1.0;
    let discountText = '';
    if (quantity >= 1000) {
        discount = 0.75;
        discountText = '已享受75折批量優惠';
    } else if (quantity >= 500) {
        discount = 0.85;
        discountText = '已享受85折批量優惠';
    } else if (quantity >= 200) {
        discount = 0.95;
        discountText = '已享受95折少量優惠';
    }

    const total = unitPrice * (quantity / 100) * discount + bindingCost;

    document.getElementById('previewPrice').textContent = 'HKD ' + total.toFixed(2);
    document.getElementById('discountInfo').textContent = discountText;
    document.getElementById('pricePreview').classList.remove('d-none');
}

document.getElementById('product').addEventListener('change', calculatePreview);
document.getElementById('size').addEventListener('change', calculatePreview);
document.getElementById('material').addEventListener('change', calculatePreview);
document.getElementById('printing_side').addEventListener('change', calculatePreview);
document.getElementById('binding').addEventListener('change', calculatePreview);
document.getElementById('quantity').addEventListener('input', calculatePreview);

calculatePreview();
</script>
@endsection
