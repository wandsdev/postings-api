<?php


namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class AuthService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * @param $credentials
     * @return bool | string
     */
    public function login($credentials)
    {
        if (! $token = auth()->attempt($credentials)) {
            return false;
        }

        return $token;
    }

    public function logout()
    {
        auth()->logout();
    }

    /**
     * @return mixed
     */
    public function refresh()
    {
        return auth()->refresh();
    }

    public function resendValidationCode($email)
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            throw new \Exception('Usuário não encontrado. Verifique seu cadastro');
        }

        $user->validation_code = $this->userService->createValidationCode();
        $user->validation_code_validation_date = $this->userService->createValidationCodeValidationDate(10);
        $user->save();
        $this->userService->sendValidationCode($user);
    }
}
