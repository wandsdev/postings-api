<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function savePhoto(Request $request): JsonResponse
    {
        extract($request->all());

        $this->userService->validateUserEmail($email);
        $user = $this->userService->savePhoto($request);

        return response()->json($user, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function updatePassword(Request $request): JsonResponse
    {
        extract($request->all());

        $validated = $request->validate([
            'email' => 'required',
            'oldPassword' => 'required|min:8',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8',
        ]);

        $this->userService->validateUpdatePassword($email, $oldPassword, $newPassword, $confirmPassword);
        $user = $this->userService->updatePassword($newPassword);

        return response()->json($user, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request): JsonResponse
    {
        extract($request->all());

        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
        ]);

        $this->userService->validateUserEmail($email);

        $user = $this->userService->update($name);

        return response()->json($user, 200);
    }

    /**
     * @return JsonResponse
     */
    public function find(): JsonResponse
    {
        return response()->json(auth()->user());
    }

}
