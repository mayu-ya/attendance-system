@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/timestamp.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="status">
            @if(!$work)
                <p class="status-p">勤務外</p>
            @elseif($work->break->whereNull('rest_time'))
                <p class="status-p">休憩中</p>
            @elseif($work->end_time)
                <p class="status-p">退勤済</p>
            @else
                <p class="status-p">勤務中</p>
            @endif
        </div>

        <div class="datetime">
            <p class="date">{{ \Carbon\Carbon::now()->isoFormat('YYYY年MM月DD日（ddd）') }}</p>
            <p class="time">{{ \Carbon\Carbon::now()->format('H:i') }}</p>
        </div>

        @if(!$work)
            <form action="/working/start" class="form" method="post">
                @csrf
                <button class="button-b">出勤</button>
            </form>
        @elseif($work->break->whereNull('rest_time'))
            <form action="/break/end" class="form" method="post">
                @csrf
                <input type="hidden" name="attendance_record_id" value="{{ $work->id }}">
                <button class="button-w">休憩戻</button>
            </form>
        @elseif($work->end_time)
            <div class="comment">
                <p class="comment-p">お疲れ様でした。</p>
            </div>
        @else
            <div class="form__group">
                <form action="/working/end" class="form" method="post">
                    @csrf
                    <input type="hidden" name="attendance_record_id" value="{{ $work->id }}">
                    <button class="button-b">退勤</button>
                </form>
                <form action="/break/start" class="form" method="post">
                    @csrf
                    <input type="hidden" name="attendance_record_id" value="{{ $work->id }}">
                    <button class="button-w">休憩入</button>
                </form>
            </div>
        @endif

        

    </div>
</div>
@endsection