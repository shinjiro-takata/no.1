@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('header_action')
<a class="header__action-link" href="{{ route('login') }}">login</a>
@endsection

@section('content')
<div class="register">
    <div class="register__heading">
        <h2>Register</h2>
    </div>

    <div class="register__card">
        <form class="register-form" action="#" method="post">
            @csrf
            <div class="register-form__group">
                <label class="register-form__label" for="name">お名前</label>
                <input class="register-form__input" id="name" type="text" name="name" placeholder="例: 山田 太郎" />
            </div>

            <div class="register-form__group">
                <label class="register-form__label" for="email">メールアドレス</label>
                <input class="register-form__input" id="email" type="email" name="email" placeholder="例: test@example.com" />
            </div>

            <div class="register-form__group">
                <label class="register-form__label" for="password">パスワード</label>
                <input class="register-form__input" id="password" type="password" name="password" placeholder="例: coachtech1106" />
            </div>

            <div class="register-form__actions">
                <button class="register-form__button" type="submit">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection