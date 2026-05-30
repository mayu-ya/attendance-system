@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/attendance.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="title">
            <h2 class="title-item">{{ \Carbon\Carbon::parse($date)->isoFormat('YYYY年M月DD日') }}の勤怠</h2>
        </div>

        <div class="date">日付 管理者ページ
            <form action="" class="form" method="post">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">
                <input type="hidden" name="action" value="sub">
                <button class="button" type="submit">←前日</button>
            </form>
            <strong class="strong">{{ $date }}</strong>
            <form action="" class="form" method="post">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">
                <input type="hidden" name="action" value="add">
                <button class="button" type="submit">翌日→</button>
            </form>
        </div>
        
        <div class="item">
            <table class="table">
                <tr class="table__inner">
                    <th class="table-title">名前</th>
                    <th class="table-title">出勤</th>
                    <th class="table-title">退勤</th>
                    <th class="table-title">休憩</th>
                    <th class="table-title">合計</th>
                    <th class="table-title">詳細</th>
                </tr>
                @foreach($works as $work)
                <tr class="table__inner">
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ $work->user->name }}" readonly>
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($work->start_time, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($work->end_time, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($work->duration, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <input type="text" class="table-input" value="{{ substr($work->work_total, 0, 5) ?? '' }}" readonly>
                    </td>
                    <td class="table-td">
                        <div class="link">
                            <a href="{{ route('admin_detail.index', ['id' => $work->id]) }}" class="link-a">詳細</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection