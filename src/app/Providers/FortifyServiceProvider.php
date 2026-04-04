<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

// Fortifyの画面設定とログイン制限をまとめる
class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 会員登録時に使う処理クラスを指定する
        Fortify::createUsersUsing(CreateNewUser::class);

        // 登録画面に使うBladeを指定する
        Fortify::registerView(function () {
            return view('register');
        });

        // ログイン画面に使うBladeを指定する
        Fortify::loginView(function () {
            return view('login');
        });

        // 同じメールアドレスとIPからのログイン試行回数を制限する
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });
    }
}
