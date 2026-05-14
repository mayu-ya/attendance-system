@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/admin_login') }}">
@endsection

@section('content')
<div class="content">
    <div class="login-title">
        <h2 class="login-title-h">管理者ログイン</h2>
    </div>
    <form action="" class="form">
        <div class="form__group">
            <div class="form-title">
                <span class="form-label"></span>
            </div>
            <div class="form__error"></div>
            <div class="form-content">
                <input type="text" class="form-input">
            </div>
        </div>
        <div class="form__group">
            <div class="form-title">
                <span class="form-label"></span>
            </div>
            <div class="form__error"></div>
            <div class="form-content">
                <input type="text" class="form-input">
            </div>
        </div>
        <div class="form-button">
            <button class="form-button__submit">管理者ログインする</button>
        </div>
    </form>
</div>
@endsection