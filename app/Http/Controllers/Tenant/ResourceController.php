<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceResource;
use App\Services\ResourceService;

class ResourceController extends Controller
{
    protected $resource;

    public function __construct(ResourceService $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @OA\Get(
     *     tags={"Resources"},
     *     path="/resources",
     *     summary="Listar todos os recursos",
     *     description="Retorna uma lista de recursos disponíveis no banco de dados.",
     *     operationId="getAllResources",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de recursos com permissões retornadas com sucesso.",
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
    public function index()
    {
        return ResourceResource::collection(
            $this->resource->getAllResources()
        );
    }
}
