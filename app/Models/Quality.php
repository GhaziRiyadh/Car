<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quality extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $table = 'qualities';

    public function product(): HasMany
    {
        return $this->hasMany(Product::class, 'quality_id');
    }
}
