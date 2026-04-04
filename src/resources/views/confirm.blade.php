@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm__content">
    <div class="page__heading">
        <h2>Confirm</h2>
    </div>
    <form class="form" action="/thanks" method="post">
        @csrf
        <div class="confirm-table">
            <table class="confirm-table__inner">
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お名前</th>
                    <td class="confirm-table__text">
                        {{ $contact['last_name'] }} {{ $contact['first_name'] }}
                        <input class="confirm-table__hidden-input" type="hidden" name="last_name" value="{{ $contact['last_name'] }}" />
                        <input class="confirm-table__hidden-input" type="hidden" name="first_name" value="{{ $contact['first_name'] }}" />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">性別</th>
                    <td class="confirm-table__text">
                        {{ \App\Models\Contact::GENDER_LABELS[(int) $contact['gender']] ?? '' }}
                        <input class="confirm-table__hidden-input" type="hidden" name="gender" value="{{ $contact['gender'] }}" />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">メールアドレス</th>
                    <td class="confirm-table__text">
                        {{ $contact['email'] }}
                        <input class="confirm-table__hidden-input" type="hidden" name="email" value="{{ $contact['email'] }}" />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">電話番号</th>
                    <td class="confirm-table__text">
                        {{ $contact['tel_full'] }}
                        <input class="confirm-table__hidden-input" type="hidden" name="tel1" value="{{ $contact['tel1'] }}" />
                        <input class="confirm-table__hidden-input" type="hidden" name="tel2" value="{{ $contact['tel2'] }}" />
                        <input class="confirm-table__hidden-input" type="hidden" name="tel3" value="{{ $contact['tel3'] }}" />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">住所</th>
                    <td class="confirm-table__text">
                        {{ $contact['address'] }}
                        <input class="confirm-table__hidden-input" type="hidden" name="address" value="{{ $contact['address'] }}" />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">建物名</th>
                    <td class="confirm-table__text">
                        {{ $contact['building'] }}
                        <input class="confirm-table__hidden-input" type="hidden" name="building" value="{{ $contact['building'] }}" />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせの種類</th>
                    <td class="confirm-table__text">
                        {{ $categoryContent }}
                        <input class="confirm-table__hidden-input" type="hidden" name="category_id" value="{{ $contact['category_id'] }}" />
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせ内容</th>
                    <td class="confirm-table__text confirm-table__text--detail">
                        <div class="confirm-table__detail-content">
                            {!! nl2br(e($contact['detail'])) !!}
                        </div>
                        <input class="confirm-table__hidden-input" type="hidden" name="detail" value="{{ $contact['detail'] }}" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">送信</button>
            <button class="form__button-back" type="submit" name="back" value="1">修正</button>
        </div>
    </form>
</div>
@endsection