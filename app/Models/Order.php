<?php

namespace App\Models;

use App\Enums\OrdersStatusEnum;
use App\Traits\HasBelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory, HasUuids, HasBelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'payment_id',
        'user_id',
        'customer_id',
        'identify',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrdersStatusEnum::class,
        ];
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot(['quantity', 'price']);
    }
}
