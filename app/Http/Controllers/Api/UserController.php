<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;

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
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
        ]);

        if ($isValid) {
            $this->userRepository->register($data);

            // 登録したユーザーでログインする
            Auth::attempt($data);
            $token = $req->user()->createToken('token-name');

            return response()->json(['api_token' => $token->plainTextToken], 200);
        }
    }
}
