<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfileRequest;
use App\Repositories\UserRepository;
use App\Traits\HasAuthenticatedUser;

class ProfileController extends Controller
{
    use HasAuthenticatedUser;

    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @OA\Put(
     *     tags={"Auth"},
     *     path="/auth/profile",
     *     summary="Atualizar perfil do usuário logado",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *        )
     *     ),
     *     @OA\Response(response=200,description="Sucesso"),
     *     @OA\Response(response="402", description="Validação de dados"),
     * )
     */    
    public function __invoke(ProfileRequest $request)
    {
        return $this->user->update(
            (array) $request->validated(), $this->getUser()->id
        );
    }
}
