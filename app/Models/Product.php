<?php

namespace App\Models;

use App\Traits\HasBelongsToTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory, HasUuids, HasBelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if (is_string($value) && str_contains($value, ',')) {
                    return (float) str_replace(",", ".", str_replace(".", "", $value));
                }
                return $value;
            },
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function commands(): BelongsToMany
    {
        return $this->belongsToMany(Command::class, 'command_item')
            ->withPivot(['id', 'quantity', 'price']);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'command_item')
            ->withPivot(['id', 'quantity', 'price']);
    }
}
