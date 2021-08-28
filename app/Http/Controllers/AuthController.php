<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountValidationRequest;
use App\Traits\TResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Notifications\VerificationCodeUserAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    use TResponse;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'accountValidation', 'resendValidationToken']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Register a User.
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->validation_code = random_int(10000000, 99999999);
        $user->validation_code_validation_date = Carbon::now()->addMinutes(10);
        $user->save();

        try {
            Notification::send($user, new VerificationCodeUserAccount($user));
        } catch (Exception $e) {
            return $this->responseExceptionError($e, 500);
        }

        return response()->json([
            'message' => 'Usuario registrado com sucesso',
            'user' => ['name' => $user->name, 'email' => $user->email]
        ], 201);
    }

    public function accountValidation(AccountValidationRequest $request): JsonResponse
    {
        $email = $request['email'];
        $validation_code = $request['validation_code'];

        $user = User::where('email', $email)->first();

        if (!$user) {
            return $this->responseError('Usuário não encontrado. Verifique seu cadastro.', 400);
        }

        $validationCodeValidationDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->validation_code_validation_date);
        $currentDate = Carbon::now();

        if ($currentDate > $validationCodeValidationDate) {
            return $this->responseError('Código de validação expirado', 400);
        }

        if ($validation_code !== $user->validation_code) {
            return $this->responseError('Código de validação inválido', 400);
        }

        $user->email_verified = true;
        $user->save();

        return response()->json([
            'status' => 'ok',
            'message' => 'Conta verificada com sucesso',
        ], 200);
    }

    public function resendValidationToken ()
    {

    }
}
