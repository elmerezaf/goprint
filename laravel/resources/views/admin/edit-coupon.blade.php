@extends('layouts.app')

@section('title', '編輯優惠券')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.coupons') }}" class="btn btn-link">
            ← 返回優惠券列表
        </a>
        <h2 class="text-2xl font-bold mt-2">編輯優惠券</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="code" class="form-label">優惠券代碼 *</label>
                    <input type="text" 
                           name="code" 
                           id="code" 
                           class="form-control @error('code') is-invalid @enderror"
                           value="{{ old('code', $coupon->code) }}"
                           required
                           placeholder="例如: SAVE20">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">折扣類型 *</label>
                    <select name="type" 
                            id="type" 
                            class="form-select @error('type') is-invalid @enderror"
                            required>
                        <option value="percentage" {{ old('type', $coupon->type) === 'percentage' ? 'selected' : '' }}>
                            百分比折扣
                        </option>
                        <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>
                            固定金額折扣
                        </option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">折扣金額/百分比 *</label>
                    <div class="input-group">
                        <input type="number" 
                               name="value" 
                               id="value" 
                               class="form-control @error('value') is-invalid @enderror"
                               value="{{ old('value', $coupon->value) }}"
                               step="0.01"
                               required
                               placeholder="輸入折扣值">
                        <span class="input-group-text" id="value-suffix">
                            {{ $coupon->type === 'percentage' ? '%' : '¥' }}
                        </span>
                    </div>
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted">
                        選擇百分比折扣時輸入百分比值（例如 20 表示 20%），選擇固定金額時輸入金額
                    </div>
                </div>

                <div class="mb-3">
                    <label for="min_order_amount" class="form-label">最低消費金額</label>
                    <div class="input-group">
                        <span class="input-group-text">¥</span>
                        <input type="number" 
                               name="min_order_amount" 
                               id="min_order_amount" 
                               class="form-control @error('min_order_amount') is-invalid @enderror"
                               value="{{ old('min_order_amount', $coupon->min_order_amount) }}"
                               step="0.01"
                               placeholder="可選，例如 100">
                    </div>
                    @error('min_order_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="usage_limit" class="form-label">使用次數限制</label>
                    <input type="number" 
                           name="usage_limit" 
                           id="usage_limit" 
                           class="form-control @error('usage_limit') is-invalid @enderror"
                           value="{{ old('usage_limit', $coupon->usage_limit) }}"
                           placeholder="可選，例如 100">
                    @error('usage_limit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted">留空表示無限制</div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="valid_from" class="form-label">有效期開始</label>
                        <input type="date" 
                               name="valid_from" 
                               id="valid_from" 
                               class="form-control @error('valid_from') is-invalid @enderror"
                               value="{{ old('valid_from', $coupon->valid_from?->format('Y-m-d')) }}">
                        @error('valid_from')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="valid_until" class="form-label">有效期結束</label>
                        <input type="date" 
                               name="valid_until" 
                               id="valid_until" 
                               class="form-control @error('valid_until') is-invalid @enderror"
                               value="{{ old('valid_until', $coupon->valid_until?->format('Y-m-d')) }}">
                        @error('valid_until')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="is_active" 
                               id="is_active"
                               {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            啟用優惠券
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">描述</label>
                    <textarea name="description" 
                              id="description" 
                              class="form-control @error('description') is-invalid @enderror"
                              rows="3"
                              placeholder="可選，輸入優惠券說明">{{ old('description', $coupon->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        更新優惠券
                    </button>
                    <a href="{{ route('admin.coupons') }}" class="btn btn-secondary">
                        取消
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        const suffix = document.getElementById('value-suffix');
        if (this.value === 'percentage') {
            suffix.textContent = '%';
        } else {
            suffix.textContent = '¥';
        }
    });
</script>
@endsection