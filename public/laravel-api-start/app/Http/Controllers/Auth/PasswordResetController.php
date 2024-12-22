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
     *     summary="Realizar alteração de senha",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="code", type="string"),
     *              @OA\Property(property="password", type="string"),
     *        )
     *     ),
     *     @OA\Response(response=200,description="Sucesso"),
     *     @OA\Response(response="400", description="Falha na requisição"),
     *     @OA\Response(response="402", description="Validação de dados"),
     *     @OA\Response(response="404", description="Não encontrado"),
     * )
     */    
    public function __invoke(PasswordResetRequest $request)
    {
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$passwordReset) {
            return response()->json(['error' => 'Código inválido ou expirado.'], 400);
        }

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado.'], 404);
        }

        DB::table('users')->where('email', $request->email)->update(['password' => bcrypt($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['success' => 'Senha alterada com sucesso!']);
    }
}
