<?php 

namespace App\Traits;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasAuthenticatedUser 
{
    private function getUser(): User
    {
        return Auth::user();
    }

    private function getTenant() : Tenant
    {
        return Auth::user()->tenant;
    }

    private function isLogged() : bool
    {
        return Auth::check();
    }
}