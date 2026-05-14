@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/admin_login') }}">
@endsection

@section('content')
<div class="content">
    <div class="login-title">
        <h2 class="login-title-h">管理者ログイン</h2>
    </div>
    <form action="" class="form">
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
                <input type="password" class="form-input" name="password" value="{{ old('password') }}">
            </div>
        </div>
        <div class="form-button">
            <button class="form-button__submit">管理者ログインする</button>
        </div>
    </form>
</div>
@endsection