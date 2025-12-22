<?php

declare(strict_types=1);

namespace Marvel\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Marvel\Enums\Permission;
use Marvel\Exceptions\MarvelException;
use Marvel\Http\Requests\CmsPageRequest;
use Marvel\Http\Resources\CmsPageResource;
use Marvel\Services\CmsPageService;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="ChawkBazar API",
 *     description="ChawkBazar E-commerce Platform REST API Documentation",
 *     @OA\Contact(
 *         email="support@chawkbazar.com",
 *         name="API Support"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(url=L5_SWAGGER_CONST_HOST, description="API Server")
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="sanctum",
 *     description="Enter your Bearer token obtained from /token endpoint"
 * )
 *
 * @OA\Tag(name="Authentication", description="User authentication and registration endpoints")
 * @OA\Tag(name="Password Management", description="Password reset and recovery endpoints")
 * @OA\Tag(name="OTP Authentication", description="One-Time Password based authentication")
 * @OA\Tag(name="Puck Pages", description="Page builder endpoints for Puck integration")
 *
 * @OA\Schema(
 *     schema="AuthResponse",
 *     type="object",
 *     @OA\Property(property="token", type="string", example="1|abc123xyz...", description="Bearer token for API authentication"),
 *     @OA\Property(property="permissions", type="array", @OA\Items(type="string"), example={"customer"}),
 *     @OA\Property(property="role", type="string", example="customer")
 * )
 *
 * @OA\Schema(
 *     schema="LoginResponse",
 *     type="object",
 *     @OA\Property(property="token", type="string", nullable=true, example="1|abc123xyz...", description="Bearer token or null if login failed"),
 *     @OA\Property(property="permissions", type="array", @OA\Items(type="string"), example={"customer"}),
 *     @OA\Property(property="email_verified", type="boolean", example=true),
 *     @OA\Property(property="role", type="string", example="customer")
 * )
 *
 * @OA\Schema(
 *     schema="MessageResponse",
 *     type="object",
 *     @OA\Property(property="message", type="string", example="Operation completed successfully"),
 *     @OA\Property(property="success", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="ValidationError",
 *     type="object",
 *     @OA\Property(
 *         property="errors",
 *         type="object",
 *         example={"email": {"The email field is required."}, "password": {"The password field is required."}}
 *     )
 * )
 */
class CmsPageController extends CoreController
{
    public function __construct(
        private readonly CmsPageService $service
    ) {
    }

    /**
     * Publicly list CMS pages with pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $limit = (int) ($request->get('limit') ?? 10);

        $pages = $this->service->paginate([], $limit);
        $data = CmsPageResource::collection($pages)->response()->getData(true);

        return response()->json(formatAPIResourcePaginate($data));
    }

    /**
     * Publicly fetch a page by slug (legacy support).
     */
    public function show(string $slug): CmsPageResource
    {
        $page = $this->service->getBySlug($slug);
        return new CmsPageResource($page);
    }

    /**
     * @OA\Get(
     *     path="/api/puck/page",
     *     operationId="getPageByPath",
     *     tags={"Puck Pages"},
     *     summary="Get page by path",
     *     description="Fetches a page by its URL path for Puck frontend rendering",
     *     @OA\Parameter(
     *         name="path",
     *         in="query",
     *         required=false,
     *         description="URL path of the page (e.g., '/', '/about')",
     *         @OA\Schema(type="string", default="/", example="/")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Page found successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="path", type="string", example="/"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="root", type="object"),
     *                 @OA\Property(property="content", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="zones", type="object")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found",
     *         @OA\JsonContent(@OA\Property(property="data", type="null"))
     *     )
     * )
     */
    public function showByPath(Request $request): JsonResponse
    {
        $path = $request->query('path', '/');

        try {
            $page = $this->service->getByPath($path);

            return response()->json([
                'path' => $page->path,
                'data' => $page->puck_data,
            ]);
        } catch (MarvelException $e) {
            return response()->json(['data' => null], 404);
        }
    }

    /**
     * Create a page (Editor or higher).
     */
    public function store(CmsPageRequest $request): JsonResponse
    {
        $this->assertEditor($request);
        $page = $this->service->create($request->validated());
        return (new CmsPageResource($page))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Post(
     *     path="/api/puck/page",
     *     operationId="savePuckPage",
     *     tags={"Puck Pages"},
     *     summary="Create or update page (upsert)",
     *     description="Creates a new page or updates existing one by path. Requires EDITOR or SUPER_ADMIN permissions.",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"path", "title"},
     *             @OA\Property(property="path", type="string", example="/", description="URL path for the page"),
     *             @OA\Property(property="title", type="string", example="Homepage", description="Page title"),
     *             @OA\Property(property="slug", type="string", nullable=true, description="URL slug (auto-generated if not provided)"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 description="Puck editor data structure",
     *                 @OA\Property(property="root", type="object", @OA\Property(property="props", type="object")),
     *                 @OA\Property(
     *                     property="content",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="type", type="string", example="HeroSlider"),
     *                         @OA\Property(property="props", type="object")
     *                     )
     *                 ),
     *                 @OA\Property(property="zones", type="object")
     *             ),
     *             @OA\Property(property="meta", type="object", nullable=true, description="SEO and other metadata")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Page saved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="path", type="string", example="/"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Forbidden - insufficient permissions"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function storePuckPage(CmsPageRequest $request): JsonResponse
    {
        $this->assertEditor($request);

        $validated = $request->validated();

        // Check if page exists for upsert
        try {
            $existingPage = $this->service->getByPath($validated['path']);
            $page = $this->service->update($existingPage->id, $validated);
        } catch (MarvelException $e) {
            // Page not found, create new
            $page = $this->service->create($validated);
        }

        return response()->json([
            'success' => true,
            'path' => $page->path,
            'data' => $page->puck_data,
        ]);
    }

    /**
     * Update a page (Editor or higher).
     */
    public function update(CmsPageRequest $request, int $id): CmsPageResource
    {
        $this->assertEditor($request);
        $page = $this->service->update($id, $request->validated());
        return new CmsPageResource($page);
    }

    /**
     * Delete a page (Editor or higher).
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->assertEditor($request);
        $this->service->delete($id);
        return response()->json(['success' => true]);
    }

    private function assertEditor(Request $request): void
    {
        $user = $request->user();

        if (!$user || (!$user->hasPermissionTo(Permission::SUPER_ADMIN) && !$user->hasPermissionTo(Permission::EDITOR))) {
            throw new MarvelException(NOT_AUTHORIZED);
        }
    }
}



