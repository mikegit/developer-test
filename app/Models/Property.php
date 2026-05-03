<?php

namespace App\Models;

use Database\Factories\PropertyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'price',
    'bedrooms',
    'bathrooms',
    'storeys',
    'garages',
    'is_test',
])]
class Property extends Model
{
    /** @use HasFactory<PropertyFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_test' => 'boolean',
        ];
    }

    /**
     * @param Builder<Property> $query
     * @param array<string, mixed> $filters
     * @return Builder<Property>
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['name'] ?? null, function (Builder $query, string $name) {
                $query->where('name', 'like', '%'.$name.'%');
            })
            ->when($filters['bedrooms'] ?? null, function (Builder $query, int $bedrooms) {
                $query->where('bedrooms', $bedrooms);
            })
            ->when($filters['bathrooms'] ?? null, function (Builder $query, int $bathrooms) {
                $query->where('bathrooms', $bathrooms);
            })
            ->when($filters['storeys'] ?? null, function (Builder $query, int $storeys) {
                $query->where('storeys', $storeys);
            })
            ->when($filters['garages'] ?? null, function (Builder $query, int $garages) {
                $query->where('garages', $garages);
            })
            ->when($filters['price_min'] ?? null, function (Builder $query, float|int|string $priceMin) {
                $query->where('price', '>=', $priceMin);
            })
            ->when($filters['price_max'] ?? null, function (Builder $query, float|int|string $priceMax) {
                $query->where('price', '<=', $priceMax);
            });
    }
}
