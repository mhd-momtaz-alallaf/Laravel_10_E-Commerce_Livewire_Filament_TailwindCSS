<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grand_total',
        'payment_method',
        'payment_status',
        'status',
        'currency',
        'shipping_amount',
        'shipping_method',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // many orders => one user.
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class); // one order => many orderItems.
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class); // one order => one address.
    }
}
