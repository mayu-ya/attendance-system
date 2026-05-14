@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="status">
            <p class="status-p">勤務外</p>
        </div>

        <div class="date">日付</div>

        <form action="" class="form">
            @csrf
            <button class="button-b">出勤</button>
        </form>
    </div>
</div>
@endsection