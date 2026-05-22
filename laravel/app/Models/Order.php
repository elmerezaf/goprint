<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'address',
        'city',
        'postal_code',
        'product',
        'size',
        'material',
        'printing_side',
        'binding',
        'quantity',
        'price',
        'file',
        'status',
        'payment_method',
        'shipping_method',
        'notes',
        'design_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
