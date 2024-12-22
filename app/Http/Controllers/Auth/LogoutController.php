<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HasAuthenticatedUser;

class LogoutController extends Controller
{
    use HasAuthenticatedUser;

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/auth/logout",
     *     summary="Revogar o token de acesso do usuário logado",
     *     description="Este endpoint permite que o usuário logado revogue o token de acesso associado ao seu dispositivo. Após o logout, o token de autenticação não será mais válido para futuras requisições.",
     *     operationId="logoutUser",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout realizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Logout realizado com sucesso!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado, token de acesso inválido ou ausente",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno no servidor",
     *     )
     * )
     */
    public function __invoke()
    {
        // Revoga todos os tokens de acesso do usuário logado
        $this->getUser()->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso!'
        ]);
    }
}
