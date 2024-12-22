<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryService $category)
    {
        $this->category = $category;
    }

    /**
     * @OA\Get(
     *     tags={"Categories"},
     *     path="/categories",
     *     summary="Listar categorias",
     *     description="Retorna uma lista de categorias com paginação e filtros opcionais.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="paginate",
     *          in="query",
     *          description="Quantidade de itens por página.",
     *          required=false,
     *          @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *          name="name", in="query", required=false,
     *          description="Filtrar categorias pelo nome.",
     *          @OA\Schema(type="string", example="Eletrônicos")
     *     ),
     *     @OA\Parameter(
     *          name="active", in="query", required=false,
     *          description="Filtrar por status ativo (true) ou inativo (false).",
     *          @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de categorias retornada com sucesso.",
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
        return CategoryResource::collection(
            $this->category->getAllCategories(
                (array) $request->all()
            )
        );
    }

    /**
     * @OA\Post(
     *     tags={"Categories"},
     *     path="/categories",
     *     summary="Criar uma nova categoria",
     *     description="Armazena uma nova categoria no banco de dados.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              required={"name", "active"},
     *              @OA\Property(property="name", type="string", description="Nome da categoria.", example="Eletrônicos"),
     *              @OA\Property(property="active", type="boolean", description="Status ativo ou inativo da categoria.", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoria criada com sucesso.",
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
    public function store(CategoryRequest $request)
    {
        return new CategoryResource(
            $this->category->createCategory(
                (array) $request->validated()
            )
        );
    }

    /**
     * @OA\Get(
     *     tags={"Categories"},
     *     path="/categories/{id}",
     *     summary="Exibir uma categoria",
     *     description="Retorna os detalhes de uma categoria pelo ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="ID da categoria a ser exibida.",
     *         @OA\Schema(type="string", format="uuid", example="0006faf6-7a61-426c-9034-579f2cfcfa83")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da categoria retornados com sucesso.",
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
     *         description="Categoria não encontrada."
     *     )
     * )
     */
    public function show(string $id)
    {
        return new CategoryResource(
            $this->category->findCategoryById($id)
        );
    }

    /**
     * @OA\Put(
     *     tags={"Categories"},
     *     path="/categories/{id}",
     *     summary="Atualizar uma categoria",
     *     description="Atualiza os dados de uma categoria existente.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="ID da categoria a ser atualizada.",
     *         @OA\Schema(type="string", format="uuid", example="0006faf6-7a61-426c-9034-579f2cfcfa83")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", description="Nome da categoria.", example="Eletrônicos"),
     *              @OA\Property(property="active", type="boolean", description="Status ativo ou inativo da categoria.", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Categoria atualizada com sucesso."
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
     *         description="Categoria não encontrada."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados enviados.",
     *     )
     * )
     */
    public function update(CategoryRequest $request, string $id)
    {
        return $this->category->updateCategory(
            (array) $request->validated(),
            $id
        );
    }

    /**
     * @OA\Delete(
     *     tags={"Categories"},
     *     path="/categories/{id}",
     *     summary="Deletar uma categoria",
     *     description="Remove uma categoria pelo ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         description="ID da categoria a ser deletada.",
     *         @OA\Schema(type="string", format="uuid", example="0006faf6-7a61-426c-9034-579f2cfcfa83")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria deletada com sucesso."
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
    public function destroy(string $id)
    {
        return $this->category->deleteCategory($id);
    }
}
