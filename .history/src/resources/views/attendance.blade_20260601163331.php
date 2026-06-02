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
            @foreach($monthDays as $monthDay)
                <tr class="table__inner">
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ $monthDay['day'] ?? $monthDay['date'] ?? '' }}">
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($monthDay['apply']?->start_time, 0, 5) ?? substr($monthDay['work']?->start_time, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($monthDay['apply']?->end_time, 0, 5) ?? substr($monthDay['work']?->end_time, 0, 5) ?? '' }}" readonly>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($monthDay['apply']?->duration, 0, 5) ?? substr($monthDay['work']?->duration, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($monthDay['apply']?->work_total, 0, 5) ?? substr($monthDay['work']?->work_total, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <div class="link">
                            @if($monthDay['apply'] or $monthDay['work'])
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