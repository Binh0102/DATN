<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'address',
        'total',
        'status',
    ];

    public function orderDetails(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_details')->withPivot('quantity', 'color');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
