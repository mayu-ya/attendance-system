@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="title">
            <h2 class="title-item">勤怠一覧</h2>
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
                    @foreach($attendances as $attendance)
                    <td class="table-td"><input type="text" class="table-input" value="{{ $attendance['date'] }}"></td>
                    <td class="table-td"><input type="text" class="table-input" value="{{ \Carbon\Carbon::parse($attendance['start_time'])->format('H:i') }}"></td>
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td"><input type="text" class="table-input"></td>
                    <td class="table-td">
                        <div class="link">
                            <a href="{{ route('detail.index') }}" class="link-a">詳細</a>
                        </div>
                    </td>
                    @endforeach
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection