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
    
        @if($apply)
        <form action="{{ route('detail.update', ['id'=>$apply->id]) }}" class="form" method="post">
        @elseif($work)
        <form action="{{ route('detail.update', ['id'=>$work->id]) }}" class="form" method="post">
        @endif
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
                            @if($apply)
                            <input type="text" name="date" class="table-item__date" value="{{ \Carbon\Carbon::parse($apply['date'])->isoFormat('YYYY年') }}" readonly>
                            <input type="text" name="date" class="table-item__date" value="{{ \Carbon\Carbon::parse($apply['date'])->isoFormat('MM月DD日') }}" readonly>
                            @elseif($work)
                            <input type="text" class="table-item__date" value="{{ \Carbon\Carbon::parse($work['date'])->isoFormat('YYYY年') }}" readonly>
                            <input type="text" class="table-item__date" value="{{ \Carbon\Carbon::parse($work['date'])->isoFormat('MM月DD日') }}" readonly>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">出勤・退勤</th>
                    <td class="table-content">
                        <div class="error">
                            @error('start_time')
                            {{ $message }}
                            @enderror
                        </div>
                        @if($apply)
                        <input type="text" name="start_time" class="table-item-list" value="{{ substr($apply->start_time, 0, 5) ?? '' }}" readonly><span class="table-span">～</span>
                        <input type="text" name="end_time" class="table-item-list" value="{{ substr($apply->end_time, 0, 5) ?? '' }}" readonly>
                        @elseif($work)
                        <input type="text" name="start_time" class="table-item" value="{{ old('start_time') ?? substr($work->start_time, 0, 5) ?? '' }}"><span class="table-span">～</span>
                        <input type="text" name="end_time" class="table-item" value="{{ old('end_time') ?? substr($work->end_time, 0, 5) ?? '' }}">
                        @endif
                    </td>
                </tr>
                @if($apply)
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
                        <input type="text" name="breaks[{{ $loop->index }}][rest_start]" class="table-item-list" value="{{ substr($break->rest_start, 0, 5) ?? '' }}" readonly><span class="table-span">～</span>
                        <input type="text" name="breaks[{{ $loop->index }}][rest_end]" class="table-item-list" value="{{ substr($break->rest_end, 0, 5) ?? '' }}" readonly>
                    </td>
                </tr>
                @endforeach
                @elseif($work)
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
                        <div class="error">
                            @error("breaks.{$loop->index}.rest_start")
                            {{ $message }}
                            @enderror
                            @error("breaks.{$loop->index}.rest_end")
                            {{ $message }}
                            @enderror
                        </div>
                        <input type="text" name="breaks[{{ $loop->index }}][rest_start]" class="table-item" value="{{ old('breaks' . $loop->index . 'rest_start') ?? substr($break->rest_start, 0, 5) ?? '' }}"><span class="table-span">～</span>
                        <input type="text" name="breaks[{{ $loop->index }}][rest_end]" class="table-item" value="{{ old('breaks' . $loop->index . 'rest_end') ?? substr($break->rest_end, 0, 5) ?? '' }}">
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
                        <div class="error">
                            @error('rest.rest_start')
                            {{ $message }}
                            @enderror
                            @error('rest.rest_end')
                            {{ $message }}
                            @enderror
                        </div>
                        <input type="text" name="rest[rest_start]" class="table-item" value="{{ old('rest' . 'rest_start') }}"><span class="table-span">～</span>
                        <input type="text" name="rest[rest_end]" class="table-item" value="{{ old('rest' . 'rest_end') }}">
                    </td>
                </tr>
                @endif
                <tr class="table__inner">
                    <th class="table-title">備考</th>
                    <td class="table-content">
                        <div class="error">
                            @error('content')
                            {{ $message }}
                            @enderror
                        </div>
                        @if($apply)
                        <textarea class="table-textarea-list" name="content" readonly>{{ $apply->content }}</textarea>
                        @elseif($work)
                        <textarea class="table-textarea" name="content">{{ old('content') }}</textarea>
                        @endif
                    </td>
                </tr>
            </table>
            <div class="button">
                @if($apply)
                <p class="update-p">*承認待ちのため修正はできません。</p>
                @elseif($work)
                <button class="button__submit" type="submit">修正</button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection