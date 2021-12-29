<?php

namespace App\Http\Trait;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

trait ValidationTrait
{
    protected function userValidation(Request $req, array $rules = [])
    {
        $validator = Validator::make($req->all(), array_merge([
            'name' => ['required', 'max:32'],
            'phone_number' => ['required', 'numeric', 'digits_between:8,11'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8'],
        ], $rules));

        if ($validator->fails()) {
            $res = response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);

            throw new HttpResponseException($res);
        }
    }
}
