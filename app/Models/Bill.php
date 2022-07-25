<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id', 'date', 'total', 'status_id', 'payment_method', 'payer_id', 'confirm_code'];

    public function seller(): Belongsto
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'bill_product', 'bill_id', 'product_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(BillStatus::class, 'status_id');
    }
}
