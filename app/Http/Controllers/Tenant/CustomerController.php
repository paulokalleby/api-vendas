<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customer;

    public function __construct(CustomerService $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @OA\Get(
     *     tags={"Customers"},
     *     path="/customers",
     *     summary="Listar todos os clientes",
     *     description="Retorna uma lista paginada de clientes com opções de filtragem por nome, email e status ativo.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *          name="paginate", in="query", description="Quantidade de itens por página.",
     *          @OA\Schema(type="integer", example=15)
     *     ),
     *     @OA\Parameter(
     *          name="name", in="query", description="Filtrar clientes pelo nome",
     *          @OA\Schema(type="string", example="John Doe")
     *     ),
     *     @OA\Parameter(
     *          name="email", in="query", description="Filtrar clientes pelo email",
     *          @OA\Schema(type="string", example="johndoe@example.com")
     *     ),
     *     @OA\Parameter(
     *          name="active", in="query", description="Filtrar por status ativo (true) ou inativo (false).",
     *          @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes retornada com sucesso.",
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
        return CustomerResource::collection(
            $this->customer->getAllCustomers(
                (array) $request->all()
            )
        );
    }

    /**
     * @OA\Post(
     *     tags={"Customers"},
     *     path="/customers",
     *     summary="Criar um novo cliente",
     *     description="Armazena um novo cliente no banco de dados.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              required={"name", "email"},
     *              @OA\Property(property="name", type="string", description="Nome do cliente", example="John Doe"),
     *              @OA\Property(property="email", type="string", description="Email do cliente", example="johndoe@example.com"),
     *              @OA\Property(property="whatsapp", type="string", description="Número do WhatsApp", example="+5511987654321"),
     *              @OA\Property(property="address", type="string", description="Endereço do cliente", example="Rua Exemplo, 123"),
     *              @OA\Property(property="active", type="boolean", description="Status ativo do cliente", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente criado com sucesso.",
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
    public function store(CustomerRequest $request)
    {
        return new CustomerResource(
            $this->customer->createCustomer(
                (array) $request->validated()
            )
        );
    }

    /**
     * @OA\Get(
     *     tags={"Customers"},
     *     path="/customers/{id}",
     *     summary="Obter detalhes de um cliente",
     *     description="Retorna os detalhes de um cliente específico pelo ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         description="UUID do cliente",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid", example="0006faf6-7a61-426c-9034-579f2cfcfa83")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do cliente retornados com sucesso.",
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
     *         description="Cliente não encontrado."
     *     )
     * )
     */
    public function show(string $id)
    {
        return new CustomerResource(
            $this->customer->findCustomerById($id)
        );
    }

    /**
     * @OA\Put(
     *     tags={"Customers"},
     *     path="/customers/{id}",
     *     summary="Atualizar dados de um cliente",
     *     description="Atualiza os dados de um cliente pelo ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         description="UUID do cliente",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid", example="0006faf6-7a61-426c-9034-579f2cfcfa83")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", description="Nome do cliente", example="John Doe"),
     *              @OA\Property(property="active", type="boolean", description="Status ativo do cliente", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Cliente atualizado com sucesso."
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
     *         description="Cliente não encontrado."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação nos dados enviados.",
     *     )
     * )
     */
    public function update(CustomerRequest $request, string $id)
    {
        return $this->customer->updateCustomer(
            (array) $request->validated(),
            $id
        );
    }

    /**
     * @OA\Delete(
     *     tags={"Customers"},
     *     path="/customers/{id}",
     *     summary="Excluir um cliente",
     *     description="Remove um cliente específico pelo ID.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         description="UUID do cliente",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid", example="0006faf6-7a61-426c-9034-579f2cfcfa83")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente excluído com sucesso."
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
     *         description="Cliente não encontrado."
     *     )
     * )
     */
    public function destroy(string $id)
    {
        return $this->customer->deleteCustomer($id);
    }
}
