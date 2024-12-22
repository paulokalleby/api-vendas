<?php

namespace App\Models;
;
use App\Traits\HasBelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory, HasUuids, HasBelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'slug',
        'active',
    ];
  
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public static function boot()
    {
        parent::boot();
    
        static::creating(function (Model $model) {
            $model->slug = Str::slug($model->name);
        });

        static::updating(function (Model $model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
