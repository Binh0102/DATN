<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'color',
    ];

    public function products(): BelongsTo
    {
        return  $this->belongsTo(Product::class, 'product_id');
    }

    public function user(): BelongsTo
    {
        return  $this->belongsTo(User::class);
    }
}
