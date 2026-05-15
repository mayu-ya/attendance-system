@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/timestamp.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="status">
            <p class="status-p">勤務外</p>
            <p class="status-p">勤務中</p>
            <p class="status-p">休憩中</p>
            <p class="status-p">退勤済</p>
        </div>

        <div class="date">{{ \Carbon\Carbon::now()->isoFormat('Y年n月j日（D）') }}</div>

        <form action="" class="form">
            @csrf
            <button class="button-b">出勤</button>
        </form>

        <div class="form__group">
            <form action="" class="form">
                @csrf
                <button class="button-b">退勤</button>
            </form>
            <form action="" class="form">
                @csrf
                <button class="button-w">休憩入</button>
            </form>
        </div>
        
        <form action="" class="form">
            @csrf
            <button class="button-w">休憩戻</button>
        </form>

        <div class="comment">
            <p class="comment-p">お疲れ様でした。</p>
        </div>

    </div>
</div>
@endsection