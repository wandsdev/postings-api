<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Services\PeriodService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * @var mixed
     */
    private $userId;
    /**
     * @var PeriodService
     */
    private $periodService;

    public function __construct(PeriodService $periodService)
    {
        $this->userId = auth()->user()->getAuthIdentifier();
        $this->periodService = $periodService;
    }

    public function findAll(Request $request): JsonResponse
    {
        $periods = $this->periodService->findAll();
        return response()->json($periods, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $this->periodService->create($request->all());
        return response()->json([], 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        extract($request->all());

        $this->periodService->update($id, $name, $start_date, $end_date);
        return response()->json([], 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $this->periodService->delete($id);
        return response()->json([], 200);
    }
}
