<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $primaryKey = 'cat_id';
    public $timestamps = false;

    protected $fillable = [
        'cat_id',
        'cat_name',
        'cat_desc',
        'create_time'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id');
    }
}