@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('hide_header', 'true')

@section('content')
<div class="thanks__content">
    <div class="thanks__inner">
        <p class="thanks__message">お問い合わせありがとうございました</p>
        <a class="thanks__button" href="{{ route('contact.index') }}">HOME</a>
    </div>
</div>
@endsection