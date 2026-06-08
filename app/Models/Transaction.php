<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
    'invoice_number',
    'user_id',
    'branch_id',
    'subtotal',
    'discount',
    'total',
    'status',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}