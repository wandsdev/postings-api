<?php

namespace App\Http\Controllers;

use App\Models\Posting;
use Illuminate\Http\Request;

class PostingController extends Controller
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
        $postings = Posting::findAll($request->all(), $this->userId);
        return response()->json($postings, 200);
    }

    public function find(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $posting = Posting::findOrFail($id);
        return response()->json($posting, 200);
    }

    public function create(Request $request)
    {
        $posting = new Posting();
        $posting->person_id = $request->person_id;
        $posting->value = $request->value;
        $posting->date = $request->date;
        $posting->description = $request->description;
        $posting->user_id = $this->userId;
        $posting->save();
        return response()->json([], 201);
    }

    public function update(Request $request, $id)
    {
        $posting = Posting::findOrFail($id);
        $posting->person_id = $request->person_id;
        $posting->value = $request->value;
        $posting->date = $request->date;
        $posting->description = $request->description;
        $posting->user_id = $this->userId;
        $posting->save();
        return response()->json([], 200);
    }

    public function delete($id)
    {
        Posting::destroy($id);
        return response()->json([], 200);
    }
}
