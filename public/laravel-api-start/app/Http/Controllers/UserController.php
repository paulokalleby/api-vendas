<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/users",
     *     summary="Obter todos os recursos do banco",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="paginate", in="query", description="Quantidade de dados por página",
     *          @OA\Schema(type="int")
     *     ),
     *     @OA\Parameter(
     *          name="name", in="query", description="Filtrar usuário pelo nome",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="email", in="query", description="Filtrar usuário pelo email",
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="active", in="query", description="Filtrar usuários ativos ou inativos",
     *          @OA\Schema(type="bool")
     *     ),
     *     @OA\Response(response=200, description="Sucesso"),
     *     @OA\Response(response="401", description="Não autenticado"),
     *     @OA\Response(response="403", description="Não autorizado"),
     *     @OA\Response(response="500", description="Erro interno"),
     * )
     */
    public function index(Request $request)
    {
        return UserResource::collection(
            $this->user->getAll( 
                (array) $request->all() 
            )
        );
    }

    /**
     * @OA\Post(
     *     tags={"Users"},
     *     path="/users",
     *     summary="Armazenar novo recurso no banco de dados",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(
     *                  property="roles",
     *                  type="array",
     *                  @OA\Items(
     *                      type="string",
     *                      format="uuid"
     *                  ),
     *                  example={"uuid1", "uuid2", "uuid3"}
     *              ),
     *              @OA\Property(property="cutomer", type="bool"),
     *              @OA\Property(property="active", type="bool"),
     *        )
     *     ),
     *     @OA\Response(response=201, description="Criado"),
     *     @OA\Response(response="401", description="Não autenticado"),
     *     @OA\Response(response="402", description="Validação de dados"),
     *     @OA\Response(response="403", description="Não autorizado"),
     *     @OA\Response(response="500", description="Erro interno"),
     * )
     */    
    public function store(UserRequest $request)
    {
        return new UserResource(
            $this->user->create( 
                (array) $request->validated() 
            )
        );
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/users/{id}",
     *     summary="Ver um recurso",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string", format="char32"),
     *         @OA\Examples(example="uuid", value="0006faf6-7a61-426c-9034-579f2cfcfa83", summary="UUID value."),
     *     ),
     *     @OA\Response(response=200,description="Sucesso"),
     *     @OA\Response(response="401", description="Não autenticado"),
     *     @OA\Response(response="403", description="Não autorizado"),
     *     @OA\Response(response="404", description="Não encontrado"),
     *     @OA\Response(response="500", description="Erro interno"),
     * )
     */    
    public function show(string $id)
    {
        return new UserResource(
            $this->user->findById($id)
        );
    }

    /**
     * @OA\Put(
     *     tags={"Users"},
     *     path="/users/{id}",
     *     summary="Atualizar um recurso no banco de dados",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string", format="char32"),
     *         @OA\Examples(example="uuid", value="0006faf6-7a61-426c-9034-579f2cfcfa83", summary="UUID value."),
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(
     *                  property="roles",
     *                  type="array",
     *                  @OA\Items(
     *                      type="string",
     *                      format="uuid"
     *                  ),
     *                  example={"uuid1", "uuid2", "uuid3"}
     *              ),
     *              @OA\Property(property="customer", type="bool"),
     *              @OA\Property(property="active", type="bool"),
     *        )
     *     ),
     *     @OA\Response(response=204, description="Atualizado"),
     *     @OA\Response(response="401", description="Não autenticado"),
     *     @OA\Response(response="402", description="Validação de dados"),
     *     @OA\Response(response="403", description="Não autorizado"),
     *     @OA\Response(response="404", description="Não encontrado"),
     *     @OA\Response(response="500", description="Erro interno"),
     * )
     */    
    public function update(UserRequest $request, string $id)
    {
        return $this->user->update(
            (array) $request->validated(), $id
        );
    }

    /**
     * @OA\Delete(
     *     tags={"Users"},
     *     path="/users/{id}",
     *     summary="Deletar recurso",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string", format="char32"),
     *         @OA\Examples(example="uuid", value="0006faf6-7a61-426c-9034-579f2cfcfa83", summary="UUID value."),
     *     ),
     *     @OA\Response(response=200,description="Sucesso"),
     *     @OA\Response(response="401", description="Não autenticado"),
     *     @OA\Response(response="403", description="Não autorizado"),
     *     @OA\Response(response="404", description="Não encontrado"),
     *     @OA\Response(response="500", description="Erro interno"),
     * )
     */    
    public function destroy(string $id)
    {
        return $this->user->delete($id);
    }
}
