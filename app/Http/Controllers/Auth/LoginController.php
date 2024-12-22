<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Post(
 *     tags={"Auth"},
 *     path="/auth/login",
 *     summary="Autenticar um usuário e gerar um token de acesso",
 *     description="Este endpoint autentica um usuário com base no email e senha fornecidos. Se as credenciais forem válidas, retorna um token de autenticação e os dados do usuário.",
 *     operationId="loginUser",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *              type="object",
 *              required={"email", "password", "device"},
 *              @OA\Property(property="email", type="string", format="email", description="Email do usuário"),
 *              @OA\Property(property="password", type="string", format="password", description="Senha do usuário"),
 *              @OA\Property(property="device", type="string", description="Nome do dispositivo para identificação do token"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Autenticado com sucesso.",
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Credenciais inválidas.",
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Usuário inativo.",
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erro de validação nos dados enviados.",
 *     )
 * )
 */
class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        if ($user->active == false) {
            throw ValidationException::withMessages([
                'message' => ['A conta do usuário está inativa.'],
            ]);
        }

        // $user->tokens()->delete(); // single access

        return (new AuthResource($user))->additional([
            'token' => $user->createToken($request->device)->plainTextToken
        ]);
    }
}
