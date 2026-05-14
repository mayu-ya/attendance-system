@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/staff.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="title">
            <h2 class="title-item">スタッフ一覧</h2>
        </div>
        
        <form action="" class="form">
            @csrf
            <table class="table">
                <tr class="table__inner">
                    <th class="table-title">名前</th>
                    <th class="table-title">メールアドレス</th>
                    <th class="table-title-button">月次勤怠</th>
                </tr>
                <tr class="table__inner">
                    <td class="table-td"><input type="text" name="" class="table-input"></td>
                    <td class="table-td"><input type="text" name="" class="table-input__email"></td>
                    <td class="table-td">
                        <div class="button">
                            <button class="button__submit">詳細</button>
                        </div>
                        <input type="hidden" name="id">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
@endsection