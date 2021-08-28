<?php

namespace App\Http\Controllers;

use App\Models\Posting;
use App\Services\PostingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostingController extends Controller
{
    /**
     * @var PostingService
     */
    private $postingService;

    public function __construct(PostingService $postingService)
    {
        $this->postingService = $postingService;
    }

    public function findAll(Request $request): JsonResponse
    {
        $postings = Posting::findAll($request->all(), $this->userId);
        return response()->json($postings, 200);
    }

    public function find(Request $request, $id): JsonResponse
    {
        $posting = Posting::findOrFail($id);
        return response()->json($posting, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $this->postingService->create($request->all());
        return response()->json([], 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $this->postingService->update($request->all(), $id);
        return response()->json([], 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $this->postingService->delete($id);
        return response()->json([], 200);
    }
}
