<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title', 'code', 'released'
    ];

    protected $casts = [
        'code' => 'hashed'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function title(): Attribute
    {
        return new Attribute(get:fn($value) => ucfirst($value));
    }

    public function scopeReleased(Builder $builder)
    {
        return $builder->whereReleased(true);
    }
}
