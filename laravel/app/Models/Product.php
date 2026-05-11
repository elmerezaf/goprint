<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 绑定表名
    protected $table = 'product';
    // 🔥 主键改成表中的 pro_id
    protected $primaryKey = 'pro_id';
    // 关闭自动时间戳（表没有 created_at/updated_at）
    public $timestamps = false;

    // 允许批量赋值的字段，必须和表中的字段名完全一致
    protected $fillable = [
        'pro_id',
        'cat_id',
        'pro_name',
        'pro_price',
        'pro_stock',
        'pro_desc',
        'create_time',
        'pro_image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }
}