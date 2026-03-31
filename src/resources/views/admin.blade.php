@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header_action')
<form class="header__logout-form" action="{{ route('logout') }}" method="post">
    @csrf
    <button class="header__action-link" type="submit">logout</button>
</form>
@endsection

@section('content')
<div class="admin">
    <div class="admin__heading">
        <h2>Admin</h2>
    </div>

    <div class="admin__content">
        <form class="search-form" action="{{ route('contact.search') }}" method="get">
            <input class="search-form__input search-form__input--keyword" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">

            <select class="search-form__input search-form__input--select" name="gender">
                <option value="">性別</option>
                <option value="1" {{ request('gender') === '1' ? 'selected' : '' }}>男性</option>
                <option value="2" {{ request('gender') === '2' ? 'selected' : '' }}>女性</option>
                <option value="3" {{ request('gender') === '3' ? 'selected' : '' }}>その他</option>
            </select>

            <select class="search-form__input search-form__input--select-wide" name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                @endforeach
            </select>

            <input class="search-form__input search-form__input--date" type="date" name="created_date" value="{{ request('created_date') }}">

            <button class="search-form__button search-form__button--search" type="submit">検索</button>
            <a class="search-form__button search-form__button--reset" href="{{ route('contact.reset') }}">リセット</a>
        </form>

        <div class="admin__toolbar">
            <form action="{{ route('contact.export') }}" method="get">
                <button class="admin__export-button" type="submit">エクスポート</button>
            </form>

            @if ($contacts->hasPages())
            <div class="pagination">
                @if ($contacts->onFirstPage())
                <span class="pagination__item pagination__item--disabled">&lt;</span>
                @else
                <a class="pagination__item" href="{{ $contacts->previousPageUrl() }}">&lt;</a>
                @endif

                @for ($page = 1; $page <= $contacts->lastPage(); $page++)
                    @if ($page == $contacts->currentPage())
                    <span class="pagination__item pagination__item--current">{{ $page }}</span>
                    @else
                    <a class="pagination__item" href="{{ $contacts->url($page) }}">{{ $page }}</a>
                    @endif
                    @endfor

                    @if ($contacts->hasMorePages())
                    <a class="pagination__item" href="{{ $contacts->nextPageUrl() }}">&gt;</a>
                    @else
                    <span class="pagination__item pagination__item--disabled">&gt;</span>
                    @endif
            </div>
            @endif
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>お名前</th>
                    <th>性別</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせの種類</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                <tr>
                    <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                    <td>{{ $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他') }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ optional($contact->category)->content }}</td>
                    <td class="admin-table__detail-cell"><button class="admin-table__detail-button" type="button">詳細</button></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="admin-table__empty">該当するデータがありません</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection