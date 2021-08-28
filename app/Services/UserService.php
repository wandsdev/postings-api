<?php


namespace App\Services;

use App\Models\User;
use App\Notifications\ValidationCodeUserAccount;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;


class UserService
{

    /**
     * @param User $user
     */
    public function sendValidationCode(User $user)
    {
        Notification::send($user, new ValidationCodeUserAccount($user));
    }

    /**
     * @param $request
     * @return User
     * @throws Exception
     */
    public function createUser($request): User
    {
        extract($request);

        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->validation_code = $this->createValidationCode();
        $user->validation_code_validation_date = $this->createValidationCodeValidationDate(10);
        $user->save();

        return $user;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function createValidationCode(): int
    {
        return random_int(10000000, 99999999);
    }

    /**
     * @param $minutes
     * @return Carbon
     */
    public function createValidationCodeValidationDate($minutes): Carbon
    {
        return Carbon::now()->addMinutes($minutes);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function codeIsExpired(User $user): bool
    {
        $validationCodeValidationDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->validation_code_validation_date);
        $currentDate = Carbon::now();
        return $currentDate > $validationCodeValidationDate;
    }

    public function checkEmail(User $user)
    {
        $user->email_verified = true;
        $user->save();
    }

}
