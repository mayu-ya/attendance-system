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
            @foreach($monthDays as $monthDay)
                <tr class="table__inner">
                    <td class="table-td"><input type="text" class="table-input" value="{{ $monthDay['date'] }}"></td>
                    <td class="table-td"><input type="text" class="table-input" value="{{ $monthDay['work']->start_time ?? '' }}" readonly></td>
                    <td class="table-td"><input type="text" class="table-input" value="{{ $monthDay['work']->end_time ?? '' }}" readonly></td>
                    <td class="table-td"><input type="text" class="table-input" value="{{ substr($monthDay['work']->duration, 0, 5) ?? '' }}" readonly></td>
                    <td class="table-td"><input type="text" class="table-input" value="{{ $monthDay['work']->work_total ?? '' }}" readonly></td>
                    <td class="table-td">
                        <div class="link">
                            @if($monthDay['work'])
                                <a href="{{ route('detail.index', ['id' => $monthDay['work']->id]) }}" class="link-a">詳細</a>
                            @else
                                <span>詳細</span>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </table>
        </div>
    </div>
</div>
@endsection