<?php

namespace App\Repositories\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(array $data)
    {
        // パスワードを暗号化
        $data['password'] = Hash::make($data['password']);

        $this->user->create($data);
    }
}
