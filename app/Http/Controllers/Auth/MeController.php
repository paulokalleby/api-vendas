<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Traits\HasAuthenticatedUser;

class MeController extends Controller
{
    use HasAuthenticatedUser;

    /**
     * @OA\Get(
     *     tags={"Auth"},
     *     path="/auth/me",
     *     summary="Consultar informações do usuário autenticado",
     *     description="Este endpoint retorna os dados do usuário autenticado com base no token de autenticação fornecido. O usuário deve estar autenticado através de um token Bearer válido para acessar suas informações pessoais.",
     *     operationId="getAuthenticatedUser",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso - Dados do usuário autenticado retornados com sucesso.",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado - O token de autenticação fornecido é inválido ou ausente.",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno no servidor - Falha ao processar a solicitação.",
     *     )
     * )
     */
    public function __invoke()
    {
        return new AuthResource(
            $this->getUser()
        );
    }
}
