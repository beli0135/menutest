<?php

namespace App\Models;

use App\Enums\ActionEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency',
        'rate',
        'surcharge_pct',
        'surcharge',
        'purchased',
        'paid',
        'discount_pct',
        'discount',
        'action',
    ];

    protected $casts = [
        'action' => ActionEnum::class,
    ];

    protected function surcharge(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => $value / 100,
            set: fn(float $value) => $value * 100,
        );
    }

    protected function purchased(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => $value / 100,
            set: fn(float $value) => $value * 100,
        );
    }

    protected function paid(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => $value / 100,
            set: fn(float $value) => $value * 100,
        );
    }

    protected function discount(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => $value / 100,
            set: fn(float $value) => $value * 100,
        );
    }
}
