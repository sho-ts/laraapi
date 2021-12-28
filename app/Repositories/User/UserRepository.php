<?php

namespace App\Repositories\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface {
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(array $data) {
        $this->user->create($data);
    }
}
