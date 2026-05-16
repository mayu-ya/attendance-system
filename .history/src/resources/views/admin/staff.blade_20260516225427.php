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
        
        <div class="item">
            <table class="table">
                <tr class="table__inner">
                    <th class="table-title">名前</th>
                    <th class="table-title">メールアドレス</th>
                    <th class="table-title">月次勤怠</th>
                </tr>
                <tr class="table__inner">
                    <td class="table-td"><input type="text" name="" class="table-input"></td>
                    <td class="table-td"><input type="text" name="" class="table-input__email"></td>
                    <td class="table-td">
                        <div class="link">
                            <a href="{{ route('admin_detail.index') }}" class="link-a">詳細</a>
                        </div>
                        <input type="hidden" name="id">
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection