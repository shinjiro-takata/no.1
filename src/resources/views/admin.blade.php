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
    <div class="page__heading">
        <h2>Admin</h2>
    </div>

    <div class="admin__content">
        <form class="search-form" action="{{ route('contact.search') }}" method="get">
            <input class="search-form__input search-form__input--keyword" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">

            <select class="search-form__input search-form__input--select" name="gender">
                <option value="">性別</option>
                @foreach (\App\Models\Contact::GENDER_LABELS as $value => $label)
                <option value="{{ $value }}" {{ request('gender') == (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <select class="search-form__input search-form__input--select search-form__input--select-wide" name="category_id">
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
                @foreach (request()->except(['modal', 'page']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
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
                <tr class="admin-table__row">
                    <th class="admin-table__heading">お名前</th>
                    <th class="admin-table__heading">性別</th>
                    <th class="admin-table__heading">メールアドレス</th>
                    <th class="admin-table__heading">お問い合わせの種類</th>
                    <th class="admin-table__heading"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                <tr class="admin-table__row">
                    <td class="admin-table__cell">{{ $contact->last_name }} {{ $contact->first_name }}</td>
                    <td class="admin-table__cell">{{ $contact->gender_label }}</td>
                    <td class="admin-table__cell">{{ $contact->email }}</td>
                    <td class="admin-table__cell">{{ optional($contact->category)->content }}</td>
                    <td class="admin-table__cell admin-table__detail-cell">
                        <a class="admin-table__detail-button" href="{{ request()->fullUrlWithQuery(['modal' => $contact->id]) }}">詳細</a>
                    </td>
                </tr>
                @empty
                <tr class="admin-table__row">
                    <td colspan="5" class="admin-table__cell admin-table__empty">該当するデータがありません</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($modalContact)
<div class="modal-overlay">
    <a class="modal-overlay__bg" href="{{ request()->fullUrlWithoutQuery('modal') }}"></a>
    <div class="modal">
        <a class="modal__close" href="{{ request()->fullUrlWithoutQuery('modal') }}">&times;</a>
        <table class="modal-table">
            <tr>
                <th class="modal-table__heading">お名前</th>
                <td class="modal-table__cell">{{ $modalContact->last_name }} {{ $modalContact->first_name }}</td>
            </tr>
            <tr>
                <th class="modal-table__heading">性別</th>
                <td class="modal-table__cell">{{ $modalContact->gender_label }}</td>
            </tr>
            <tr>
                <th class="modal-table__heading">メールアドレス</th>
                <td class="modal-table__cell">{{ $modalContact->email }}</td>
            </tr>
            <tr>
                <th class="modal-table__heading">電話番号</th>
                <td class="modal-table__cell">{{ $modalContact->tel }}</td>
            </tr>
            <tr>
                <th class="modal-table__heading">住所</th>
                <td class="modal-table__cell">{{ $modalContact->address }}</td>
            </tr>
            <tr>
                <th class="modal-table__heading">建物名</th>
                <td class="modal-table__cell">{{ $modalContact->building }}</td>
            </tr>
            <tr>
                <th class="modal-table__heading">お問い合わせの種類</th>
                <td class="modal-table__cell">{{ optional($modalContact->category)->content }}</td>
            </tr>
            <tr>
                <th class="modal-table__heading">お問い合わせ内容</th>
                <td class="modal-table__cell">{{ $modalContact->detail }}</td>
            </tr>
        </table>
        <form class="modal__delete-form" action="{{ route('contact.delete', $modalContact->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="modal__delete-button" type="submit">削除</button>
        </form>
    </div>
</div>
@endif
@endsection