<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Post(
 *     tags={"Auth"},
 *     path="/auth/login",
 *     summary="Gerar token de autenticão",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="email", type="string"),
 *              @OA\Property(property="password", type="string"),
 *              @OA\Property(property="device", type="string"),
 *        )
 *     ),
 *     @OA\Response(response=200,description="Sucesso"),
 *     @OA\Response(response="402", description="Validação de dados"),
 *     @OA\Response(response="404", description="Não encontrado"),
 * )
 */
class LoginController extends Controller
{    
    public function __invoke(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();
    
        if ( !$user || !Hash::check($request->password, $user->password) ) {
            
            throw ValidationException::withMessages([
    
                'message' => ['As credenciais fornecidas estão incorretas.'],
            
            ]);
            
        }

        if( $user->active == false ) {

            throw ValidationException::withMessages([
    
                'message' => ['A conta do usuário está inativa.'],
            
            ]);
        }

        //$user->tokens()->delete(); // single access
        
        return (new UserResource($user))->additional([
            'token' => $user->createToken($request->device)->plainTextToken
        ]);

    }

}
