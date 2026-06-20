@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/report.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <h1 class="title">マイ勤怠レポート</h1>
        <p class="font">過去6ヶ月の勤怠データから集計しています。</p>
        <div class="item">
            <h2 class="title-h">基本サマリー</h2>
            <div class="summary">
                <div class="summary-item">
                    <p class="summary-p">総労働時間</p>
                    <div class="summary-time">{{ sprintf('%01dh%01dm', floor($total / 60), $>total % 60) }}</div>
                </div>
                <div class="summary-item">
                    <p class="summary-p">総残業時間</p>
                    <div class="summary-time">{{ sprintf('%01dh%01dm', floor($count->total_overtime / 60), $count->total_overtime % 60) }}</div>
                </div>
                <div class="summary-item">
                    <p class="summary-p">平均労働時間/日</p>
                    <div class="summary-time">{{ sprintf('%01dh%01dm', floor($count->average_work / 60), $count->average_work % 60) }}</div>
                </div>
            </div>
        </div>

        <div class="item">
            <h2 class="title-h">月次推移（過去6ヶ月）</h2>
            <table class="table">
                <tr class="table__inner">
                    <td class="table-title-first">月</td>
                    <td class="table-title">労働時間</td>
                    <td class="table-title">残業時間</td>
                </tr>
                @foreach($reports as $report)
                <tr class="table__inner">
                    <th class="table-item-first">{{ $report->month }}</th>
                    <th class="table-item">{{ sprintf('%01dh%01dm', floor($report->total_work / 60), $report->total_work % 60) }}</th>
                    <th class="table-item">{{ sprintf('%01dh%01dm', floor($report->total_overtime / 60), $report->total_overtime % 60) }}</th>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="item">
            <h2 class="title-h">今月の異常検知</h2>
            <p class="font-p">基準:始業 9:00 / 終業 18:00 / 長時間労働は1日10時間超</p>
            <div class="count">
                <div class="time-count">
                    <p class="count-p">遅刻回数</p>
                    <div class="count-div">{{ $count->behind_time }} 回</div>
                </div>
                <div class="time-count">
                    <p class="count-p">早退回数</p>
                    <div class="count-div">{{ $count->leaving_early }} 回</div>
                </div>
                <div class="time-count">
                    <p class="count-p">長時間労働日数</p>
                    <div class="count-div">{{ $count->overtime_day }}日</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection