<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyCodeRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VerifyResetCodeController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/auth/password/verify",
     *     summary="Validar código de recuperação de senha",
     *     description="Este endpoint verifica se o código de recuperação de senha fornecido pelo usuário é válido e não expirou. O código é comparado com o código armazenado no banco de dados e a validade é verificada com base no tempo de criação do código. Caso o código seja válido e dentro do prazo de validade, o usuário poderá prosseguir com a redefinição da senha.",
     *     operationId="verifyPasswordResetCode",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              required={"email", "code"},
     *              @OA\Property(property="email", type="string", example="usuario@exemplo.com", description="O e-mail do usuário que solicita a verificação do código de recuperação."),
     *              @OA\Property(property="code", type="string", example="123456", description="O código de recuperação enviado para o e-mail do usuário.")
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Código validado com sucesso. O usuário pode prosseguir com a redefinição da senha.",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Falha na requisição. O código é inválido ou expirado.",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados enviados, como e-mail ou código mal formatados.",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno ao validar o código.",
     *     )
     * )
     */
    public function __invoke(VerifyCodeRequest $request)
    {
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$reset) {
            return response()->json(['message' => 'Código inválido.'], 400);
        }

        $createdAt = Carbon::parse($reset->created_at);
        $now = Carbon::now();

        if ($now->diffInMinutes($createdAt) > 15) {
            return response()->json(['message' => 'O código expirou.'], 400);
        }

        return response()->json(['message' => 'Código validado, informe a nova senha!']);
    }
}
