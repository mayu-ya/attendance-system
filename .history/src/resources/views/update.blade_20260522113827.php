@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/update.css') }}">
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
                    <td class="table-content"><input type="text" name="" class="table-item__name"></td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">日付</th>
                    <td class="table-content"><input type="text" name="" class="table-item__date"></td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">出勤・退勤</th>
                    <td class="table-content">
                        <input type="text" name="" class="table-item"><span class="table-span">～</span><input type="text" name="" class="table-item">
                    </td>
                </tr>
                @foreach($breaks as $break)
                <tr class="table__inner">
                    <th class="table-title">
                        @if($break === 0)
                            休憩
                        @else
                            休憩{{ $break + 1 }}
                        @endif
                    </th>
                    <td class="table-content">
                        <input type="text" name="" class="table-item"><span class="table-span">～</span>
                        <input type="text" name="" class="table-item">
                   </td>
                </tr>
                @endforeach
                <tr class="table__inner">
                    <th class="table-title">
                        @if( count($break) === 0 )
                            休憩
                        @else
                            休憩{{ count($break) + 1 }}
                        @endif
                        </th>
                    <td class="table-content">
                        <input type="text" name="rest_start" class="table-item"><span class="table-span">～</span>
                        <input type="text" name="rest_end" class="table-item">
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">備考</th>
                    <td class="table-content"><textarea class="table-textarea" name="" id=""></textarea></td>
                </tr>
            </table>
            <div class="update">
                <p class="update-p">*承認待ちのため修正はできません。</p>
            </div>
        </form>
    </div>
</div>
@endsection