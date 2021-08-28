<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Notifications\ValidationCodeUserAccount;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * @var mixed
     */
    private $userId;
    private $userEmail;
    private $userPassword;

    public function __construct()
    {
        $this->userId = auth()->user() ? auth()->user()->getAuthIdentifier() : null ;
        $this->userEmail = auth()->user() ? auth()->user()->email : null;
        $this->userPassword = auth()->user() ? auth()->user()->password : null ;
    }

    public function savePhoto(Request $request)
    {
        $this->validateUserEmail($request);

        if(empty($request->file('photo'))) {
            $photoPublicPath = '';
        } else {
            $name = time() . Str::random(24) . '.' . $request->file('photo')->getClientOriginalExtension();
            $photoPublicPath = $request->file('photo')->storePubliclyAs('public/user/photos', $name);
        }

        $user = User::findOrFail($this->userId);
        $user->photo = $photoPublicPath;
        $user->save();
        return response()->json($user, 200);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'oldPassword' => 'required|min:8',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8',
        ]);

        $this->validateUpdatePassword($request);

        $user = User::findOrFail($this->userId);
        $user->password = Hash::make($request->newPassword);
        $user->save();
        return response()->json($user, 200);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
        ]);

        $this->validateUserEmail($request);

        $user = User::findOrFail($this->userId);
        $user->name = $request->name;
        $user->save();
        return response()->json($user, 200);
    }

    public function validateUserEmail(Request $request)
    {
        if ($this->userEmail !== $request->email) {
            throw new \Exception('Email informado não confere com email do usuário');
        }
    }

    public function validateUpdatePassword(Request $request)
    {
        $this->validateUserEmail($request);

        if (!Hash::check($request->oldPassword, $this->userPassword)) {
            throw new \Exception('Senha atual não confere');
        }

        if (Hash::check($request->newPassword, $this->userPassword)) {
            throw new \Exception('Senha nova não pode ser igual a atual');
        }

        if ($request->confirmPassword !== $request->newPassword) {
            throw new \Exception('As senhas do campos Nova senha e Confirme nova senha não são igual');
        }
    }

    /**
     * @return JsonResponse
     */
    public function find(): JsonResponse
    {
        return response()->json(auth()->user());
    }

}
