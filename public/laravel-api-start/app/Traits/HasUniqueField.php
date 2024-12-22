<?php 

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

trait HasUniqueField
{

    public function unique(String $model, String $id = null)
    {
        if( $id ) {

            return Rule::unique($model)->ignore($id)->where(
                fn ($query) => $query->whereTenantId( Auth::user()->tenant_id )
            );

        } else {

            return Rule::unique($model)->where(
                fn ($query) => $query->whereTenantId( Auth::user()->tenant_id )
            );

        }

    }
}