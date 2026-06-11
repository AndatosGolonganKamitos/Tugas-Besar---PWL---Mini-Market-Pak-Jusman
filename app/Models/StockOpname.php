<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
   protected $fillable = [
    'product_stock_id',
    'stock_system',
    'stock_fisik',
    'selisih',
    'reason',
    'user_id'
];

    public function productStock()
    {
        return $this->belongsTo(ProductStock::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}