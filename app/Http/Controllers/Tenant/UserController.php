<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/users",
     *     summary="Listar usuários",
     *     description="Retorna uma lista de usuários cadastrados, com suporte a paginação e filtros.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="paginate",
     *          in="query",
     *          description="Quantidade de itens por página.",
     *          required=false,
     *          @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="Filtrar usuários pelo nome.",
     *          required=false,
     *          @OA\Schema(type="string", example="John")
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          description="Filtrar usuários pelo email.",
     *          required=false,
     *          @OA\Schema(type="string", example="john.doe@example.com")
     *     ),
     *     @OA\Parameter(
     *          name="active",
     *          in="query",
     *          description="Filtrar por status ativo (true) ou inativo (false).",
     *          required=false,
     *          @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários retornada com sucesso.",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado, usuário não autenticado."
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Acesso negado, usuário sem permissão."
     *     ),
     * )
     */
    public function index(Request $request)
    {
        return UserResource::collection(
            $this->user->getAllUsers(
                (array) $request->all()
            )
        );
    }

    /**
     * @OA\Post(
     *     tags={"Users"},
     *     path="/users",
     *     summary="Criar um novo usuário",
     *     description="Adiciona um novo usuário ao banco de dados.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Nome do usuário.", example="John Doe"),
     *             @OA\Property(property="email", type="string", description="Email do usuário.", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", description="Senha do usuário.", example="password123"),
     *             @OA\Property(property="active", type="boolean", description="Status do usuário (ativo ou inativo).", example=true),
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 description="Lista de IDs dos papéis associados ao usuário.",
     *                 @OA\Items(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário criado com sucesso."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado, usuário não autenticado."
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Acesso negado, usuário sem permissão."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados enviados.",
     *     )
     * )
     */
    public function store(UserRequest $request)
    {
        return new UserResource(
            $this->user->createUser(
                (array) $request->validated()
            )
        );
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/users/{id}",
     *     summary="Obter um usuário",
     *     description="Retorna os detalhes de um usuário específico.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="ID único do usuário.",
     *         @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do usuário retornados com sucesso.",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado, usuário não autenticado."
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Acesso negado, usuário sem permissão."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado."
     *     )
     * )
     */
    public function show(string $id)
    {
        return new UserResource(
            $this->user->findUserById($id)
        );
    }

    /**
     * @OA\Put(
     *     tags={"Users"},
     *     path="/users/{id}",
     *     summary="Atualizar um usuário",
     *     description="Atualiza as informações de um usuário existente.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="ID único do usuário.",
     *         @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Nome atualizado do usuário.", example="Jane Doe"),
     *             @OA\Property(property="email", type="string", description="Email atualizado do usuário.", example="jane.doe@example.com"),
     *             @OA\Property(property="active", type="boolean", description="Status atualizado do usuário.", example=false),
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 description="Lista de IDs atualizados dos papéis associados ao usuário.",
     *                 @OA\Items(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Usuário atualizado com sucesso."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado, usuário não autenticado."
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Acesso negado, usuário sem permissão."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados enviados.",
     *     )
     * )
     */
    public function update(UserRequest $request, string $id)
    {
        return $this->user->updateUser(
            (array) $request->validated(),
            $id
        );
    }

    /**
     * @OA\Delete(
     *     tags={"Users"},
     *     path="/users/{id}",
     *     summary="Excluir um usuário",
     *     description="Remove um usuário do banco de dados.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="ID único do usuário.",
     *         @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário removido com sucesso."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado, usuário não autenticado."
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Acesso negado, usuário sem permissão."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado."
     *     )
     * )
     */
    public function destroy(string $id)
    {
        return $this->user->deleteUser($id);
    }
}
