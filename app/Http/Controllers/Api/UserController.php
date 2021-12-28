<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * ユーザー作成
     */
    public function register(Request $req)
    {
        $data = $req->all();

        // バリデーション
        $isValid = $req->validate([
            'name' => ['required'],
            'phone_number' => ['required', 'numeric', 'digits_between:8,11'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($isValid) {
            // パスワードを暗号化
            $data['password'] = Hash::make($data['password']);

            $this->userRepository->register($data);

            return response()->json($data);
        }
    }
}
