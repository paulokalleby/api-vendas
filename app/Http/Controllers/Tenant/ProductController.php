<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductService $product)
    {
        $this->product = $product;
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/products",
     *     summary="Listar produtos",
     *     description="Obtém uma lista de produtos com filtros opcionais e paginação.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="paginate", in="query", description="Quantidade de itens por página.",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="name", in="query", description="Filtrar produtos pelo nome",
     *         @OA\Schema(type="string", example="Smartphone")
     *     ),
     *     @OA\Parameter(
     *         name="category_id", in="query", description="Filtrar produtos por ID de categoria",
     *         @OA\Schema(type="string", format="uuid", example="d290f1ee-6c54-4b01-90e6-d701748f0851")
     *     ),
     *     @OA\Parameter(
     *         name="active", in="query", description="Filtrar por status ativo (true) ou inativo (false)",
     *         @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de produtos retornada com sucesso.",
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
        return ProductResource::collection(
            $this->product->getAllProducts(
                $request->all()
            )
        );
    }

    /**
     * @OA\Post(
     *     tags={"Products"},
     *     path="/products",
     *     summary="Criar produto",
     *     description="Armazena um novo produto no banco de dados.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"category_id", "name", "price", "image"},
     *             @OA\Property(property="category_id", type="string", format="uuid", example="d290f1ee-6c54-4b01-90e6-d701748f0851"),
     *             @OA\Property(property="name", type="string", example="Smartphone"),
     *             @OA\Property(property="description", type="string", example="Descrição do produto."),
     *             @OA\Property(property="price", type="number", format="float", example=1999.99),
     *             @OA\Property(property="active", type="boolean", example=true),
     *             @OA\Property(property="image", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produto criado com sucesso.",
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
    public function store(ProductRequest $request)
    {
        return new ProductResource(
            $this->product->createProduct(
                $request->validated()
            )
        );
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/products/{id}",
     *     summary="Exibir produto",
     *     description="Retorna os detalhes de um produto específico.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id", in="path", required=true, description="ID do produto",
     *         @OA\Schema(type="string", format="uuid", example="0006faf6-7a61-426c-9034-579f2cfcfa83")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do produto retornados com sucesso.",
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
     *         description="Produto não encontrado."
     *     )
     * )
     */
    public function show($id)
    {
        return new ProductResource(
            $this->product->findProductById($id)
        );
    }

    /**
     * @OA\Put(
     *     tags={"Products"},
     *     path="/products/{id}",
     *     summary="Atualizar produto",
     *     description="Atualiza os dados de um produto existente.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id", in="path", required=true, description="ID do produto a ser atualizado",
     *         @OA\Schema(type="string", format="uuid", example="0006faf6-7a61-426c-9034-579f2cfcfa83")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="category_id", type="string", format="uuid", example="d290f1ee-6c54-4b01-90e6-d701748f0851"),
     *             @OA\Property(property="name", type="string", example="Smartphone"),
     *             @OA\Property(property="description", type="string", example="Descrição do produto."),
     *             @OA\Property(property="price", type="number", format="float", example=1999.99),
     *             @OA\Property(property="active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Produto atualizado com sucesso."
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
     *         description="Produto não encontrado."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados enviados.",
     *     )
     * )
     */
    public function update(ProductRequest $request, $id)
    {
        $this->product->updateProduct(
            $request->validated(),
            $id
        );
        return response()->noContent();
    }

    /**
     * @OA\Delete(
     *     tags={"Products"},
     *     path="/products/{id}",
     *     summary="Excluir produto",
     *     description="Remove um produto do banco de dados.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id", in="path", required=true, description="ID do produto",
     *         @OA\Schema(type="string", format="uuid", example="0006faf6-7a61-426c-9034-579f2cfcfa83")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Produto excluído com sucesso."
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
     *         description="Produto não encontrado."
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->product->deleteProduct($id);
        return response()->noContent();
    }
}
