<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequest;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/auth/password/reset",
     *     summary="Alterar a senha do usuário usando um código de redefinição",
     *     description="Este endpoint permite que o usuário altere sua senha após fornecer um código de redefinição válido enviado por e-mail. O código de redefinição tem um tempo de expiração e pode ser usado uma única vez.",
     *     operationId="resetPassword",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              required={"email", "code", "password"},
     *              @OA\Property(property="email", type="string", example="usuario@exemplo.com", description="O endereço de e-mail do usuário que solicitou a redefinição de senha."),
     *              @OA\Property(property="code", type="string", example="123456", description="O código de redefinição enviado para o e-mail do usuário."),
     *              @OA\Property(property="password", type="string", example="novaSenha123", description="A nova senha que será definida para o usuário.")
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Senha alterada com sucesso.",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Falha na requisição, código inválido ou expirado.",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado com o e-mail fornecido.",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados enviados, como senha inválida.",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor.",
     *     )
     * )
     */
    public function __invoke(PasswordResetRequest $request)
    {
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'Código inválido ou expirado.'], 400);
        }

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        DB::table('users')->where('email', $request->email)->update(['password' => bcrypt($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Senha alterada com sucesso!']);
    }
}
