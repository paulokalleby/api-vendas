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
     *     summary="Validar código de recuperação",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="code", type="string"),
     *        )
     *     ),
     *     @OA\Response(response=200,description="Sucesso"),
     *     @OA\Response(response="400", description="Falha na requisição"),
     *     @OA\Response(response="402", description="Validação de dados"),
     * )
     */
    public function __invoke(VerifyCodeRequest $request)
    {
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$reset) {
            return response()->json(['error' => 'Código inválido.'], 400);
        }

        $createdAt = Carbon::parse($reset->created_at);
        $now = Carbon::now();

        if ($now->diffInMinutes($createdAt) > 15) {
            return response()->json(['error' => 'O código expirou.'], 400);
        }

        return response()->json(['success' => 'Código validado, informe a nova senha!.']);
    }
}
