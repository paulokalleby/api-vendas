<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait HasBelongsToTenant
{
    protected static function bootHasBelongsToTenant()
    {
        if (Auth::check() && Auth::user()->tenant_id) {

            static::creating(function (Model $model) {

                $model->tenant_id = Auth::user()->tenant_id;
            });

            static::addGlobalScope('tenant_id', function (Builder $query) {

                $query->where('tenant_id', Auth::user()->tenant_id);
            });
        } else {

            static::creating(function (Model $model) {

                if (Auth::check() && Auth::user()->tenant_id) {

                    $model->tenant_id = Auth::user()->tenant_id;
                }
            });

            static::addGlobalScope('tenant_id', function (Builder $query) {

                if (Auth::check() && Auth::user()->tenant_id) {

                    $query->where('tenant_id', Auth::user()->tenant_id);
                }
            });
        }
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
