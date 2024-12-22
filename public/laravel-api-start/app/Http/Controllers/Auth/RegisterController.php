<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;

class RegisterController extends Controller
{

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/auth/register",
     *     summary="Registrar conta de usuário",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(property="device", type="string"),
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created"
     *     )
     * )
     */    
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        return new UserResource($user);

    }
}
