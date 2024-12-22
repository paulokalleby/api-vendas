<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\HasAuthenticatedUser;

class MeController extends Controller
{
    use HasAuthenticatedUser;

    /**
     * @OA\Get(
     *     tags={"Auth"},
     *     path="/auth/me",
     *     summary="Consultar usuário autenticado",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Sucesso"),
     *     @OA\Response(response="401", description="Não autenticado"),
     * )
     */    
    public function __invoke()
    {
        return new UserResource(
            $this->getUser()
        );
    }
}
