<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Models\Tenant;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/auth/register",
     *     summary="Registrar uma nova conta de usuário",
     *     description="Este endpoint permite o registro de uma nova conta de usuário. Durante o processo, será criado um novo 'tenant' (empresa) e um usuário associado com a permissão de proprietário (owner).",
     *     operationId="registerUser",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="company", type="string", example="Empresa Exemplo", description="Nome da empresa ou negócio do usuário."),
     *              @OA\Property(property="name", type="string", example="João Silva", description="Nome completo do usuário."),
     *              @OA\Property(property="email", type="string", example="joao@exemplo.com", description="Email único para o usuário, que será utilizado para autenticação."),
     *              @OA\Property(property="password", type="string", example="senha123", description="Senha do usuário, que será usada para autenticação."),
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Conta de usuário registrada com sucesso. Retorna o recurso do usuário recém-criado.",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados enviados.",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno no servidor, não foi possível registrar o usuário.",
     *     )
     * )
     */
    public function __invoke(RegisterRequest $request)
    {
        $tenant = Tenant::create([
            'name'  => $request->company,
            'email' => $request->email,
        ]);

        $user = $tenant->users()->create(
            array_merge([
                'owner' => true,
            ], $request->validated())
        );

        return new AuthResource($user);
    }
}
