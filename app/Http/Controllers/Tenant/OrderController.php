<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;

    public function __construct(OrderService $order)
    {
        $this->order = $order;
    }

    /**
     * @OA\Get(
     *     tags={"Orders"},
     *     path="/orders",
     *     summary="Obter todos os recursos",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="paginate", in="query", description="Quantidade de dados por página.",
     *          @OA\Schema(type="int")
     *     ),
     *     @OA\Parameter(
     *          name="identify", in="query", description="Filtrar recurso pelo número identificador",
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *          name="order_id", in="query", description="Filtrar recurso pelo id do usuário",
     *          @OA\Schema(type="string", format="char32")
     *     ),
     *     @OA\Parameter(
     *          name="customer_id", in="query", description="Filtrar recurso pelo id do cliente",
     *          @OA\Schema(type="string", format="char32")
     *     ),
     *     @OA\Parameter(
     *          name="payment_id", in="query", description="Filtrar recurso pelo id da forma de pagamento",
     *          @OA\Schema(type="string", format="char32")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de pedidos retornada com sucesso.",
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
        return OrderResource::collection(
            $this->order->getAllOrders(
                (array) $request->all()
            )
        );
    }

    /**
     * @OA\Post(
     *     tags={"Orders"},
     *     path="/orders",
     *     summary="Armazenar novo recurso no banco de dados",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="customer_id",
     *                  type="string",
     *                  format="uuid",
     *                  description="ID do cliente",
     *                  example="d290f1ee-6c54-4b01-90e6-d701748f0851"
     *              ),
     *              @OA\Property(
     *                  property="payment_id",
     *                  type="string",
     *                  format="uuid",
     *                  description="ID da forma de pagamento",
     *                  example="d290f1ee-6c54-4b01-90e6-d701748f0851"
     *              ),
     *              @OA\Property(
     *                  property="products",
     *                  type="array",
     *                  @OA\Items(
     *                       @OA\Property(
     *                           property="product_id",
     *                           type="string",
     *                           format="uuid",
     *                           description="ID do produto",
     *                           example="d290f1ee-6c54-4b01-90e6-d701748f0851"
     *                       ),
     *                       @OA\Property(
     *                           property="quantity",
     *                           type="integer",
     *                           description="Quantidade do produto",
     *                           example=5,
     *                           minimum=1
     *                       )
     *                  )
     *              ),
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pedido criado com sucesso."
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
    public function store(OrderRequest $request)
    {
        return new OrderResource(
            $this->order->createOrder(
                (array) $request->validated()
            )
        );
    }

    /**
     * @OA\Get(
     *     tags={"Orders"},
     *     path="/orders/{id}",
     *     summary="Ver um recurso",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string", format="char32"),
     *         @OA\Examples(example="uuid", value="0006faf6-7a61-426c-9034-579f2cfcfa83", summary="UUID value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do pedido retornados com sucesso.",
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
     *         description="Pedido não encontrado."
     *     )
     * )
     */
    public function show(string $id)
    {
        return new OrderResource(
            $this->order->findOrderById($id)
        );
    }

    /**
     * @OA\Put(
     *     tags={"Orders"},
     *     path="/orders/{id}",
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
     *              @OA\Property(property="status", type="string"),
     *        )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Pedido atualizado com sucesso."
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
     *         description="Pedido não encontrado."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados enviados.",
     *     )
     * )
     */
    public function update(OrderRequest $request, string $id)
    {
        return $this->order->updateOrder(
            (array) $request->validated(),
            $id
        );
    }

    /**
     * @OA\Delete(
     *     tags={"Orders"},
     *     path="/orders/{id}",
     *     summary="Deletar recurso",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string", format="char32"),
     *         @OA\Examples(example="uuid", value="0006faf6-7a61-426c-9034-579f2cfcfa83", summary="UUID value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pedido removido com sucesso."
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
     *         description="Pedido não encontrado."
     *     )
     * )
     */
    public function destroy(string $id)
    {
        return $this->order->deleteOrder($id);
    }
}
