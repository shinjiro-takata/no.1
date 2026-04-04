@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('header_action')
<a class="header__action-link header__action-link--auth" href="{{ route('login') }}">login</a>
@endsection

@section('content')
<div class="register">
    <div class="page__heading">
        <h2>Register</h2>
    </div>

    <div class="register__card">
        <form class="register-form" action="{{ route('register') }}" method="post" novalidate>
            @csrf
            <div class="register-form__group">
                <label class="register-form__label" for="name">お名前</label>
                <input class="register-form__input" id="name" type="text" name="name" placeholder="例: 山田 太郎" value="{{ old('name') }}" />
                <div class="register-form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="register-form__group">
                <label class="register-form__label" for="email">メールアドレス</label>
                <input class="register-form__input" id="email" type="email" name="email" placeholder="例: test@example.com" value="{{ old('email') }}" />
                <div class="register-form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="register-form__group">
                <label class="register-form__label" for="password">パスワード</label>
                <input class="register-form__input" id="password" type="password" name="password" placeholder="例: coachtech1106" />
                <div class="register-form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="register-form__actions">
                <button class="register-form__button" type="submit">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection