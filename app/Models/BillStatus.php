<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BillStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function bills():HasMany
    {
        return $this->hasMany(Bill::class, 'status_id');
    }
}
