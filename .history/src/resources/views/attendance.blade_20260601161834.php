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

        <div class="date">
            <form action="{{ route('attendance.index') }}" class="form" method="post">
                @csrf
                <input type="hidden" name="year" value="{{ $thisMonth->format('Y') }}">
                <input type="hidden" name="month" value="{{ $thisMonth->format('m') }}">
                <input type="hidden" name="action" value="sub">
                <button class="button" type="submit">←前月</button>
            </form>
            <div class="day">
                <strong class="thisday">{{ $thisMonth->format('Y/m') }}</strong>
            </div>
            <form action="{{ route('attendance.index') }}" class="form" method="post">
                @csrf
                <input type="hidden" name="year" value="{{ $thisMonth->format('Y') }}">
                <input type="hidden" name="month" value="{{ $thisMonth->format('m') }}">
                <input type="hidden" name="action" value="add">
                <button class="button" type="submit">翌月→</button>
            </form>
        </div>
        
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
            @if($applyDays)
            @foreach($applyDays as $applyDay)
                <tr class="table__inner">
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ $applyDay['date'] }}">
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($applyDay['apply']?->start_time, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($applyDay['apply']?->end_time, 0, 5) ?? '' }}" readonly>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($applyDay['apply']?->duration, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($applyDay['apply']?->work_total, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <div class="link">
                            @if($applyDay['apply'])
                                <a href="{{ route('detail.index', ['id' => $applyDay['apply']->id]) }}" class="link-a">詳細</a>
                            @else
                                <span>詳細</span>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            @else
            @foreach($monthDays as $monthDay)
                <tr class="table__inner">
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ $monthDay['date'] }}">
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($monthDay['work']?->start_time, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($monthDay['work']?->end_time, 0, 5) ?? '' }}" readonly>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($monthDay['work']?->duration, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($monthDay['work']?->work_total, 0, 5) ?? '' }}" readonly>
                    </td>
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
            @endif
            </table>
        </div>
    </div>
</div>
@endsection