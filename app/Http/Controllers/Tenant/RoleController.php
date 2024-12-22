<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $role;

    public function __construct(RoleService $role)
    {
        $this->role = $role;
    }

    /**
     * @OA\Get(
     *     tags={"Roles"},
     *     path="/roles",
     *     summary="Listar papéis",
     *     description="Retorna uma lista de papéis (roles) com suporte a paginação e filtros opcionais.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="paginate", 
     *         in="query", 
     *         description="Quantidade de itens por página.",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="name", 
     *         in="query", 
     *         description="Filtrar resultados pelo nome do papel.",
     *         @OA\Schema(type="string", example="Admin")
     *     ),
     *     @OA\Parameter(
     *         name="active", 
     *         in="query", 
     *         description="Filtrar por status ativo (true) ou inativo (false).",
     *         @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de papéis retornada com sucesso.",
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
        return RoleResource::collection(
            $this->role->getAllRoles((array) $request->all())
        );
    }

    /**
     * @OA\Post(
     *     tags={"Roles"},
     *     path="/roles",
     *     summary="Criar um novo papel",
     *     description="Armazena um novo papel no sistema. É necessário fornecer um nome único e opcionalmente associar permissões.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name"},
     *             @OA\Property(property="name", type="string", description="Nome do papel", example="Manager"),
     *             @OA\Property(property="active", type="boolean", description="Status do papel", example=true),
     *             @OA\Property(
     *                 property="permissions",
     *                 type="array",
     *                 description="Lista de UUIDs das permissões associadas.",
     *                 @OA\Items(type="string", format="uuid")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Papel criado com sucesso.",
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
    public function store(RoleRequest $request)
    {
        return new RoleResource(
            $this->role->createRole((array) $request->validated())
        );
    }

    /**
     * @OA\Get(
     *     tags={"Roles"},
     *     path="/roles/{id}",
     *     summary="Exibir detalhes de um papel",
     *     description="Retorna informações detalhadas de um papel específico identificado pelo seu UUID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID do papel a ser recuperado.",
     *         @OA\Schema(type="string", format="uuid"),
     *         example="0006faf6-7a61-426c-9034-579f2cfcfa83"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do papel retornados com sucesso.",
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
     *         description="Papel não encontrado."
     *     )
     * )
     */
    public function show(string $id)
    {
        return new RoleResource(
            $this->role->findRoleById($id)
        );
    }

    /**
     * @OA\Put(
     *     tags={"Roles"},
     *     path="/roles/{id}",
     *     summary="Atualizar um papel existente",
     *     description="Atualiza informações de um papel específico, como nome, status e permissões associadas.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID do papel a ser atualizado.",
     *         @OA\Schema(type="string", format="uuid"),
     *         example="0006faf6-7a61-426c-9034-579f2cfcfa83"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Nome do papel", example="Editor"),
     *             @OA\Property(property="active", type="boolean", description="Status do papel", example=true),
     *             @OA\Property(
     *                 property="permissions",
     *                 type="array",
     *                 description="Lista de UUIDs das permissões associadas.",
     *                 @OA\Items(type="string", format="uuid")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Papel atualizado com sucesso."
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
     *         description="Papel não encontrado."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados enviados.",
     *     )
     * )
     */
    public function update(RoleRequest $request, string $id)
    {
        return $this->role->updateRole((array) $request->validated(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Roles"},
     *     path="/roles/{id}",
     *     summary="Excluir um papel",
     *     description="Remove um papel do sistema identificado pelo seu UUID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID do papel a ser excluído.",
     *         @OA\Schema(type="string", format="uuid"),
     *         example="0006faf6-7a61-426c-9034-579f2cfcfa83"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Papel excluído com sucesso."
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
     *         description="Papel não encontrado."
     *     )
     * )
     */
    public function destroy(string $id)
    {
        return $this->role->deleteRole($id);
    }
}
