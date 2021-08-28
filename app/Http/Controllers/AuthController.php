<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountValidationRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Traits\TResponse;
use App\Services\AuthService;
use App\Services\UserService;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Exception;

class AuthController extends Controller
{
    use TResponse;

    /**
     * @var AuthService
     */
    private $authService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Create a new AuthController instance.
     *
     * @param AuthService $authService
     * @param UserService $userService
     * @param UserRepository $userRepository
     */
    public function __construct(AuthService $authService, UserService $userService, UserRepository $userRepository)
    {
        $this->middleware('auth:api', [
            'except' => ['login', 'register', 'accountValidation', 'resendValidationToken']
        ]);
        $this->authService = $authService;
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        $token = $this->authService->login($credentials);

        if (!$token) {
            return $this->responseError('Unauthorized', 401);
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
    public function logout(): JsonResponse
    {
        try {
            $this->authService->logout();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return $this->responseExceptionError($e);
        }
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken($this->refresh());
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
        try {
            $user = $this->userService->createUser($request->all());
            $this->userService->sendValidationCode($user);

            return response()->json([
                'message' => 'Usuario registrado com sucesso',
                'user' => ['name' => $user->name, 'email' => $user->email]
            ], 201);

        } catch (Exception $e) {
            return $this->responseExceptionError($e, 500);
        }
    }

    public function accountValidation(AccountValidationRequest $request): JsonResponse
    {
        $email = $request['email'];
        $validation_code = $request['validation_code'];

        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            return $this->responseError('Usuário não encontrado. Verifique seu cadastro.', 400);
        }

        if ($this->userService->codeIsExpired($user)) {
            return $this->responseError('Código de validação expirado', 400);
        }

        if ($validation_code !== $user->validation_code) {
            return $this->responseError('Código de validação inválido', 400);
        }

        $this->userService->checkEmail($user);

        return response()->json([
            'status' => 'ok',
            'message' => 'Conta verificada com sucesso',
        ], 200);
    }

    public function resendValidationToken ()
    {

    }
}
