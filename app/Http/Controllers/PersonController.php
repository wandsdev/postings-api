<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PersonController extends Controller
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
        $people = Person::where('user_id', $this->userId)->get();
        return response()->json($people, 200);
    }

    public function create(Request $request)
    {
        $person = new Person();
        $person->name = $request->name;
        $person->user_id = $this->userId;
        $person->save();
        return response()->json([], 201);
    }

    public function update(Request $request, $id)
    {
        $person = Person::findOrFail($id);
        $person->name = $request->name;
        $person->user_id = $this->userId;
        $person->save();
        return response()->json([], 200);
    }

    public function delete($id)
    {
        Person::destroy($id);
        return response()->json([], 200);
    }
}
