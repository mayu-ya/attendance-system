@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="title">
            <h2 class="title-item">勤怠詳細</h2>
        </div>
        
        <form action="" class="form">
            @csrf
            <table class="table">
                <tr class="table__inner">
                    <th class="table-title">名前</th>
                    <td class="table-content"><input type="text" class="table-item__name" value="{{ $user->name }}" readonly></td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">日付</th>
                    <td class="table-content">
                        <input type="text" class="table-item__date" value="{{ $work->date->isoFormat('YYYY年') }}" readonly>
                        <input type="text" class="table-item__date" value="{{ $work->date->isoFormat('MM月DD日') }}" readonly>
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">出勤・退勤</th>
                    <td class="table-content">
                        <input type="text" name="start_time" class="table-item" value="{{ \Carbon\Carbon::parse($work['start_time'])->format('H:i') }}"><span class="table-span">～</span>
                        <input type="text" name="end_time" class="table-item" value="{{ \Carbon\Carbon::parse($work['end_time'])->format('H:i') }}">
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">休憩</th>
                    <td class="table-content">
                        <input type="text" name="rest_start" class="table-item" value=""><span class="table-span">～</span>
                        <input type="text" name="rest_end" class="table-item" value="">
                   </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">休憩2</th>
                    <td class="table-content">
                        <input type="text" name="" class="table-item"><span class="table-span">～</span>
                        <input type="text" name="" class="table-item">
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">備考</th>
                    <td class="table-content"><textarea class="table-textarea" name="content"></textarea></td>
                </tr>
            </table>
            <div class="button">
                <button class="button__submit" type="submit">修正</button>
            </div>
        </form>
    </div>
</div>
@endsection