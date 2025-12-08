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
     * Publicly fetch a page by slug.
     */
    public function show(string $slug): CmsPageResource
    {
        $page = $this->service->getBySlug($slug);
        return new CmsPageResource($page);
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

