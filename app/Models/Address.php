<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'orders_id',
        'first_name',
        'last_name',
        'phone',
        'street_address',
        'city',
        'state',
        'zip_code',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class); // each one address => one order, because the relation is one to one from the other side.
    }

    /**
     * Get the user's full name by combining first and last name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function fullName(): Attribute // this accessor is for Get the user's full name by combining first and last name.
    {
        return Attribute::make(
            get: function (): string {
                $firstName = $this->first_name ?? '';
                $lastName = $this->last_name ?? '';
                
                return "{$firstName} {$lastName}";
            }
        );
    }
}
