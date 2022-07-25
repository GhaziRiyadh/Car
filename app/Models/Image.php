<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'imageable_id', 'imageable_type', 'type'];

    public function imageable(): BelongsTo
    {
        return $this->morphTo();
    }
}
