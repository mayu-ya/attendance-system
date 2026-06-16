@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/report.css') }}">
@endsection

@section('content')
<div class="content">
    <h3>マイ勤怠レポート</h3>
    <p class="font">過去6ヶ月の勤怠データから集計しています。</p>
    <div class="item"></div>
    <div class="item">
        <table class="table">
            <tr class="table__inner">
                <td class="table-title">月</td>
                <td class="table-title">労働時間</td>
                <td class="table-title">残業時間</td>
            </tr>
            <tr class="table__inner">
                <th class="table-item"></th>
                <th class="table-item"></th>
                <th class="table-item"></th>
            </tr>
        </table>
    </div>
    <div class="item">
        <p>基準:始業 9:00 / 終業 18:00 / 長時間労働は1日10時間超</p>
        <div class="count"></div>
    </div>
</div>
@endsection