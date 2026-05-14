@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/apply_wait.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="title">
            <h2 class="title-item">申請一覧</h2>
        </div>

        <div class="content__group">
            <div class="content-title__wait">承認待ち</div>
            <div class="content-title">承認済み</div>
        </div>

        <form action="" class="form">
            @csrf
            <table class="table">
                <tr class="table__inner">
                    <th class="table title">状態</th>
                    <th class="table title">名前</th>
                    <th class="table title">対象日時</th>
                    <th class="table title">申請理由</th>
                    <th class="table title">申請日時</th>
                    <th class="table title">詳細</th>
                </tr>
                <tr class="table__inner">
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td">
                        <div class="button">
                            <button class="button__submit">詳細</button>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
@endsection