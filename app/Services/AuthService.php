<?php


namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;

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
        $this->generateAndSendValidationCode($email);
    }

    public function forgotPassword($email)
    {
        $this->generateAndSendValidationCode($email, true);
    }

    public function resetPassword($params)
    {
        extract($params);

        $user = $this->findUserByEmailOrFail($email);

        if ($this->userService->codeIsExpired($user)) {
            throw new \Exception('Código de validação expirado', 400);
        }

        if ($validation_code !== $user->validation_code) {
            throw new \Exception('Código de validação inválido', 400);
        }

        if (Hash::check($password, $user->password)) {
            throw new Exception('A senha nova não pode ser igual a última', 400);
        }

        if ($password_confirmation !== $password) {
            throw new Exception('As senhas do campos Nova senha e Confirme nova senha não são iguais', 400);
        }

        $user->password = Hash::make($password);
        $user->save();
    }

    private function generateAndSendValidationCode($email, $isResetPassword = false)
    {
        $user = $this->findUserByEmailOrFail($email);

        $user->validation_code = $this->userService->createValidationCode();
        $user->validation_code_validation_date = $this->userService->createValidationCodeValidationDate(10);
        $user->save();
        $this->userService->sendValidationCode($user, $isResetPassword);
    }

    public function findUserByEmailOrFail($email)
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw new \Exception('Usuário não encontrado. Verifique seu cadastro');
        }

        return $user;
    }
}
