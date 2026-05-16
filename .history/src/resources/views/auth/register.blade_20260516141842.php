@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="login-title">
        <h2 class="login-title-h">会員登録</h2>
    </div>
    <form action="/register" method="post" class="form">
        @csrf
        <div class="form__group">
            <div class="form-title">
                <span class="form-label">名前</span>
            </div>
            <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
            <div class="form-content">
                <input type="email" class="form-input" name="name" value="{{ old('name') }}">
            </div>
        </div>
        <div class="form__group">
            <div class="form-title">
                <span class="form-label">メールアドレス</span>
            </div>
            <div class="form__error">
                @error('email')
                {{ $message }}
                @enderror
            </div>
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
        <div class="form__group">
            <div class="form-title">
                <span class="form-label">パスワード確認</span>
            </div>
            <div class="form__error">
                @error('password')
                {{ $message }}
                @enderror
            </div>
            <div class="form-content">
                <input type="password" class="form-input" name="password_confirmation">
            </div>
        </div>
        <div class="form-button">
            <button class="form-button__submit">ログインする</button>
        </div>
    </form>
    <div class="login__link">
        <a href="" class="login__link-item">ログインはこちら</a><br>
    </div>
</div>
@endsection