<?php

namespace App\Actions\Fortify;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

// 会員登録時のバリデーションと保存処理を行う
class CreateNewUser implements CreatesNewUsers
{
    // 入力値を検証して新しいユーザーを作成する
    public function create(array $input): User
    {
        $request = new RegisterRequest();

        // RegisterRequest のルールとメッセージでバリデーションを実行
        $validated = Validator::make(
            $input,
            $request->rules(),
            $request->messages()
        )->validate();

        // パスワードはハッシュ化して保存する
        return User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    }
}
