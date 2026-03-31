@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('header_action')
<a class="header__action-link auth-header__action-link" href="{{ route('register') }}">register</a>
@endsection

@section('content')
<div class="login">
    <div class="login__heading">
        <h2>Login</h2>
    </div>

    <div class="login__card">
        <form class="login-form" action="{{ route('login') }}" method="post" novalidate>
            @csrf
            <div class="login-form__group">
                <label class="login-form__label" for="email">メールアドレス</label>
                <input class="login-form__input" id="email" type="email" name="email" placeholder="例: test@example.com" value="{{ old('email') }}" />
                <div class="login-form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="login-form__group">
                <label class="login-form__label" for="password">パスワード</label>
                <input class="login-form__input" id="password" type="password" name="password" placeholder="例: coachtech1106" />
                <div class="login-form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="login-form__actions">
                <button class="login-form__button" type="submit">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection