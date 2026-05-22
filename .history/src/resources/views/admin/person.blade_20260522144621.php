@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/person.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="title">
            <h2 class="title-item">{{ $user->name }}さんの勤怠</h2>
        </div>

        <div class="date">日付</div>
        
        <div class="item">
            <table class="table">
                <tr class="table__inner">
                    <th class="table-title">日付</th>
                    <th class="table-title">出勤</th>
                    <th class="table-title">退勤</th>
                    <th class="table-title">休憩</th>
                    <th class="table-title">合計</th>
                    <th class="table-title">詳細</th>
                </tr>
                <tr class="table__inner">
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td">
                        <div class="button">
                            <a href="{{ route('admin_detail.index') }}" class="link-a">詳細</a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <form action="" class="form-csv">
            @csrf
            <button class="form-csv-button">CSV出力</button>
        </form>
    </div>
</div>
@endsection