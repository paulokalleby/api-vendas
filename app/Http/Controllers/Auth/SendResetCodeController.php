<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendResetCodeController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/auth/password/code",
     *     summary="Enviar código de recuperação de senha",
     *     description="Este endpoint envia um código de recuperação de senha para o e-mail do usuário, caso o e-mail fornecido esteja registrado no sistema. O código gerado é enviado por e-mail e é utilizado para redefinir a senha do usuário.",
     *     operationId="sendPasswordResetCode",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              required={"email"},
     *              @OA\Property(property="email", type="string", example="usuario@exemplo.com", description="O e-mail do usuário para o qual o código de recuperação de senha será enviado.")
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Código de recuperação enviado com sucesso.",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado com o e-mail fornecido.",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados enviados, como e-mail inválido.",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno ao enviar o código.",
     *     )
     * )
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        $code = rand(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $code, 'created_at' => Carbon::now()]
        );

        Mail::raw("Seu código de verificação é: $code", function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Código de Redefinição de Senha');
        });

        return response()->json(['message' => 'Código enviado para o e-mail!']);
    }
}
