<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * @var mixed
     */
    private $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->getAuthIdentifier();
    }

    public function findAll(Request $request): \Illuminate\Http\JsonResponse
    {
        $periods = Period::where(
            'user_id', $this->userId
        )->orderBy('id', 'desc')->get();
        return response()->json($periods, 200);
    }

    public function create(Request $request)
    {
        $period = new Period();
        $period->name = $request->name;
        $period->start_date = $request->start_date;
        $period->end_date = $request->end_date;
        $period->user_id = $this->userId;
        $period->save();
        return response()->json([], 201);
    }

    public function update(Request $request, $id)
    {
        $period = Period::findOrFail($id);
        $period->name = $request->name;
        $period->start_date = $request->start_date;
        $period->end_date = $request->end_date;
        $period->user_id = $this->userId;
        $period->save();
        return response()->json([], 200);
    }

    public function delete($id)
    {
        Period::destroy($id);
        return response()->json([], 200);
    }
}
