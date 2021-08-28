<?php


namespace App\Repositories;


use App\Models\User;

class UserRepository extends Repository
{
    /** @var User $model*/
    protected $model;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}
