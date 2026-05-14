@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/detail.css') }}">
@endsection

@section('content')
<div class="content">
    <h2 class="title">勤怠詳細</h2>
    <form action="" class="form">
        @csrf
        <table class="table">
            <tr class="table_inner">
                <th class="table-title"></th>
                <td class="table-content"><input type="text" name="" class="table-item"></td>
            </tr>
            <tr class="table_inner">
                <th class="table-title"></th>
                <td class="table-content"><input type="text" name="" class="table-item"></td>
            </tr>
            <tr class="table_inner">
                <th class="table-title"></th>
                <td class="table-content"><input type="text" name="" class="table-item"></td>
            </tr>
            <tr class="table_inner">
                <th class="table-title"></th>
                <td class="table-content"><input type="text" name="" class="table-item"></td>
            </tr>
            <tr class="table_inner">
                <th class="table-title"></th>
                <td class="table-content"><input type="text" name="" class="table-item"></td>
            </tr>
            <tr class="table_inner">
                <th class="table-title"></th>
                <td class="table-content"><textarea class="table-textarea" name="" id=""></textarea></td>
            </tr>
        </table>
        <button class="button" type="submit">修正</button>
    </form>
</div>
@endsection