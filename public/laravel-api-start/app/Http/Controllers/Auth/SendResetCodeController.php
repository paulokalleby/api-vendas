<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Validator;
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
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string"),
     *        )
     *     ),
     *     @OA\Response(response=200,description="Sucesso"),
     *     @OA\Response(response="402", description="Validação de dados"),
     *     @OA\Response(response="404", description="Não encontrado"),
     * )
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado.'], 404);
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

        return response()->json(['success' => 'Código enviado para o e-mail!']);
    }
}
