@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="login-title">
        <h2 class="login-title-h">ログイン</h2>
    </div>
    <form action="/login" method="post" class="form">
        @csrf
        <div class="form__group">
            <div class="form-title">
                <span class="form-label">メールアドレス</span>
            </div>
            <div class="form__error"></div>
            <div class="form-content">
                <input type="email" class="form-input" name="email" value="{{ old('email') }}">
            </div>
        </div>
        <div class="form__group">
            <div class="form-title">
                <span class="form-label">パスワード</span>
            </div>
            <div class="form__error"></div>
            <div class="form-content">
                <input type="password" class="form-input" name="password">
            </div>
        </div>
        <div class="form-button">
            <button class="form-button__submit">ログインする</button>
        </div>
    </form>
    <div class="login__link">
        <a href="" class="login__link-item">会員登録はこちら</a><br>
        <a href="" class="login__link-item">管理者ログインはこちら</a>
    </div>
</div>
@endsection