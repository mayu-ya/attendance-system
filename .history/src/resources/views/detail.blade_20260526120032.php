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
    
        <div class="form">
            <table class="table">
                <tr class="table__inner">
                    <th class="table-title">名前</th>
                    <td class="table-content"><input type="text" class="table-item__name" value="{{ $work->user->name }}" readonly></td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">日付</th>
                    <td class="table-content">
                        <div class="input-date">
                            <input type="text" class="table-item__date" value="{{ \Carbon\Carbon::parse($work['date'])->isoFormat('YYYY年') }}" readonly>
                            <input type="text" class="table-item__date" value="{{ \Carbon\Carbon::parse($work['date'])->isoFormat('MM月DD日') }}" readonly>
                        </div>
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">出勤・退勤</th>
                    <td class="table-content">
                        <input type="text" name="start_time" class="table-item" value="{{ substr($work->start_time, 0, 5) ?? '' }}"><span class="table-span">～</span>
                        <input type="text" name="end_time" class="table-item" value="{{ substr($work->end_time, 0, 5) ?? '' }}">
                    </td>
                </tr>
                @foreach($breaks as $break)
                <tr class="table__inner">
                    <th class="table-title">
                        @if($loop->first)
                            休憩
                        @else
                            休憩{{ $loop->iteration }}
                        @endif
                    </th>
                    <td class="table-content">
                        <input type="text" name="rest_start" class="table-item" value="{{ substr($break->rest_start, 0, 5) ?? '' }}"><span class="table-span">～</span>
                        <input type="text" name="rest_end" class="table-item" value="{{ substr($break->rest_end, 0, 5) ?? '' }}">
                   </td>
                </tr>
                @endforeach
                <tr class="table__inner">
                    <th class="table-title">
                        @if($breaks === 0)
                            休憩
                        @else
                            休憩{{ count($breaks) + 1 }}
                        @endif
                    </th>
                    <td class="table-content">
                        <input type="text" name="rest_start" class="table-item"><span class="table-span">～</span>
                        <input type="text" name="rest_end" class="table-item">
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">備考</th>
                    <td class="table-content"><textarea class="table-textarea" name="content"></textarea></td>
                </tr>
            </table>
            <div class="button">
                <p class="update-p">*承認待ちのため修正はできません。</p>
            </div>
        </div>

        <form action="{{ route('detail.update') }}" class="form" method="post">
            @csrf
            <table class="table">
                <tr class="table__inner">
                    <th class="table-title">名前</th>
                    <td class="table-content"><input type="text" class="table-item__name" value="{{ $work->user->name }}" readonly></td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">日付</th>
                    <td class="table-content">
                        <div class="input-date">
                            <input type="text" class="table-item__date" value="{{ \Carbon\Carbon::parse($work['date'])->isoFormat('YYYY年') }}" readonly>
                            <input type="text" class="table-item__date" value="{{ \Carbon\Carbon::parse($work['date'])->isoFormat('MM月DD日') }}" readonly>
                        </div>
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">出勤・退勤</th>
                    <td class="table-content">
                        <input type="text" name="start_time" class="table-item" value="{{ substr($work->start_time, 0, 5) ?? '' }}"><span class="table-span">～</span>
                        <input type="text" name="end_time" class="table-item" value="{{ substr($work->end_time, 0, 5) ?? '' }}">
                    </td>
                </tr>
                @foreach($breaks as $break)
                <tr class="table__inner">
                    <th class="table-title">
                        @if($loop->first)
                            休憩
                        @else
                            休憩{{ $loop->iteration }}
                        @endif
                    </th>
                    <td class="table-content">
                        <input type="text" name="rest_start" class="table-item" value="{{ substr($break->rest_start, 0, 5) ?? '' }}"><span class="table-span">～</span>
                        <input type="text" name="rest_end" class="table-item" value="{{ substr($break->rest_end, 0, 5) ?? '' }}">
                   </td>
                </tr>
                @endforeach
                <tr class="table__inner">
                    <th class="table-title">
                        @if($breaks === 0)
                            休憩
                        @else
                            休憩{{ count($breaks) + 1 }}
                        @endif
                    </th>
                    <td class="table-content">
                        <input type="text" name="rest_start" class="table-item"><span class="table-span">～</span>
                        <input type="text" name="rest_end" class="table-item">
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