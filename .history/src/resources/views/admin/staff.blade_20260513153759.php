@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/staff.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="title">
        <h2 class="title-item">スタッフ一覧</h2>
    </div>

    <form action="" class="form">
        @csrf
        <table class="table">
            <tr class="table__inner">
                <span class="table-span">名前</span>
                <span class="table-span">メールアドレス</span>
                <span class="table-span">月次勤怠</span>
            </tr>
            <tr class="table__inner">
                <input type="text" name="" class="table-input">
                <input type="text" name="" class="table-input__email">
                <input type="hidden" name="id">
                <div class="button">
                    <button class="button__submit">詳細</button>
                </div>
            </tr>
        </table>
    </form>
</div>
@endsection