@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/email.css') }}">
@endsection

@section('content')
<div class="content">
    <h2 class="content-h">
        登録していただいたメールアドレスに認証メールを送付しました。
    </h2>
    <h2 class="content-h">メール認証を完了してください。</h2>
    <form action="{{ route('verification.send') }}" class="form" method="post">
        @csrf
        <button class="button-form">認証はここから</button>
    </form>
    <form action="{{ route('verification.send') }}" class="email" method="post">
        @csrf
        <button class="button-email">認証メールを再送する</button>
    </form>
</div>
@endsection