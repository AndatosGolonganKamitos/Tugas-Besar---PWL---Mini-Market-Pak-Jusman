<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category_id',
        'purchase_price',
        'selling_price',
        'stock',
        'barcode',
        'supplier_id',
        'min_stock',
        'unit',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}