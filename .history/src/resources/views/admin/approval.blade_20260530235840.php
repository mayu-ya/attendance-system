@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/approval.css') }}">
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
                    <td class="table-content">
                        <input type="text" name="" class="table-item__name" value="{{ $apply->user->name }}" readonly>
                        <input type="hidden" name="id" value="{{ $apply->id }}">
                        <input type="hidden" name="attendance_record_id" value="{{ $apply->attendance_record_id }}>
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">日付</th>
                    <td class="table-content_date">
                        <input type="text" name="" class="table-item__date" value="{{ $apply->date_year }}" readonly>
                        <input type="text" name="" class="table-item__date" value="{{ $apply->date_day }}" readonly>
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">出勤・退勤</th>
                    <td class="table-content">
                        <input type="text" name="" class="table-item" value="{{ $apply->start_time }}" readonly><span class="table-span">～</span>
                        <input type="text" name="" class="table-item" value="{{ $apply->end_time }}" readonly>
                    </td>
                </tr>
                @foreach($apply->rests as $rest)
                <tr class="table__inner">
                    <th class="table-title">
                        @if($loop->first)
                            休憩
                        @else
                            休憩{{ $loop->iteration }}
                        @endif
                    </th>
                    <td class="table-content">
                        <input type="text" name="" class="table-item" value="{{ $rest->rest_start }}" readonly><span class="table-span">～</span>
                        <input type="text" name="" class="table-item" vlaue="{{ $rest->rest_end }}" readonly>
                   </td>
                </tr>
                @endforeach
                <tr class="table__inner">
                    <th class="table-title">
                        @if($apply->rests === 0)
                            休憩
                        @else
                            休憩{{ count($apply->rests) + 1 }}
                        @endif
                    </th>
                    <td class="table-content">
                        <input type="text" name="" class="table-item"><span class="table-span">～</span>
                        <input type="text" name="" class="table-item">
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">備考</th>
                    <td class="table-content"><textarea class="table-textarea" name="content" readonly>{{ $apply->content }}</textarea></td>
                </tr>
            </table>
            <div class="button">
                <div class="button-div">
                    <button class="button__submit" type="submit">承認</button>
                </div>
                <div class="button-div">
                    <button class="button__submit-but" type="button">承認済み</button>
                </div>
                
            </div>
        </form>
    </div>
</div>
@endsection