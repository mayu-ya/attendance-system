@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/approval.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="title">
            <h2 class="title-item"></h2>
        </div>

        <form action="" class="form">
            @csrf
            <table class="table">
                <tr class="table__inner">
                    <th class="table-title">名前</th>
                    <td class="table-content"><input type="text" name="" class="table-item__name"></td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">日付</th>
                    <td class="table-content"><input type="text" name="" class="table-item__date"></td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">出勤・退勤</th>
                    <td class="table-content">
                        <input type="text" name="" class="table-item"><span class="table-span">～</span><input type="text" name="" class="table-item">
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">休憩</th>
                    <td class="table-content">
                        <input type="text" name="" class="table-item"><span class="table-span">～</span><input type="text" name="" class="table-item">
                   </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">休憩2</th>
                    <td class="table-content">
                        <input type="text" name="" class="table-item"><span class="table-span">～</span><input type="text" name="" class="table-item">
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">備考</th>
                    <td class="table-content"><textarea class="table-textarea" name="" id=""></textarea></td>
                </tr>
            </table>
            <div class="button">
                <div class="button-div">
                    <button class="button__submit" type="submit">承認</button>
                </div>
                <div class="button-div">
                    <button class="button__submit-but" type="button">承認済み</button>
                </div>
                
            </div>
        </form>
    </div>
</div>
@endsection