<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\ResourceResource;
use App\Services\ResourceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResourceController extends Controller
{
    private $resourceService;

    public function __construct(ResourceService $resourceService)
    {
        $this->resourceService = $resourceService;
    }
    /**
     * @OA\Get(
     *     path="/resources",
     *     summary="Get all resources",
     *     tags={"Resources"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Resource")
     *         )
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return ResourceResource::collection($this->resourceService->getAllResources());
    }
    /**
     * @OA\Post(
     *     path="/resources",
     *     summary="Create a new resource",
     *     tags={"Resources"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ResourceRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created successfully"
     *     )
     * )
     */
    public function store(CreateResourceRequest $request): ResourceResource
    {
        $resource = $this->resourceService->createResource($request->validated());
        return new ResourceResource($resource);
    }

    public function show(int $id): ResourceResource
    {
        return new ResourceResource($this->resourceService->getResource($id));
    }

    public function update(UpdateResourceRequest $request, int $id): ResourceResource
    {
        $resource = $this->resourceService->updateResource($id, $request->validated());
        return new ResourceResource($resource);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->resourceService->deleteResource($id);
        return response()->json(['message' => 'Resource deleted successfully']);
    }

    public function getBookings(int $id): AnonymousResourceCollection
    {
        return BookingResource::collection($this->resourceService->getResourceBookings($id));
    }
}
