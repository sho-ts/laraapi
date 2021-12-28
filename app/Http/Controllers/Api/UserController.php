<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

    /**
     * apiトークン発行
     */
    public function authenticate(Request $req)
    {
        $data = $req->all();

        if (Auth::attempt($data)) {
            $token = $req->user()->createToken('token-name');

            return response()->json(['api_token' => $token->plainTextToken], 200);
        }
    }

    /**
     * ユーザー情報アップデート
     */
    public function update(Request $req)
    {
        $data = $req->all();
        $user = User::find($req->user()->id);

        // バリデーション
        $isValid = $req->validate([
            'name' => ['required'],
            'phone_number' => ['required', 'numeric', 'digits_between:8,11'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        if ($isValid) {
            $this->userRepository->update($user, $data);

            return response()->json($data);
        }
    }
}
