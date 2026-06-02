@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/detail.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="title">
            <h2 class="title-item">勤怠詳細</h2>
        </div>
        
        <form action="{{ route('admin_request.update', ['id' => $work->id]) }}" class="form" method="post">
            @csrf
            <table class="table">
                <tr class="table__inner">
                    <th class="table-title">名前</th>
                    <td class="table-content"><input type="text" name="name" class="table-item__name" value="{{ $work->user->name }}" readonly"></td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">日付</th>
                    <td class="table-content">
                        @if($apply)
                        <input type="text" name="date" class="table-item__date" value="{{ $apply->date }}" readonly>
                        @elseif($work)
                        <input type="text" name="date" class="table-item__date" value="{{ $work->date }}" readonly>
                        @endif
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">出勤・退勤</th>
                    <td class="table-content">
                        <div class="error">
                            @error('start_time')
                            {{ $message }}
                            @enderror
                            @error('end_time')
                            {{ $message }}
                            @enderror
                        </div>
                        @if($apply)
                        <input type="text" name="start_time" class="table-item" value="{{ substr($work->start_time, 0, 5) ?? '' }}"><span class="table-span">～</span>
                        <input type="text" name="end_time" class="table-item" value="{{ substr($work->end_time, 0, 5) ?? '' }}">
                        @elseif($work)
                        <input type="text" name="start_time" class="table-item" value="{{ substr($work->start_time, 0, 5) ?? '' }}"><span class="table-span">～</span>
                        <input type="text" name="end_time" class="table-item" value="{{ substr($work->end_time, 0, 5) ?? '' }}">
                        @endif
                    </td>
                </tr>
                @if($apply)
                @foreach($apply->rests as $break)
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
                            @error('rest_start')
                            {{ $message }}
                            @enderror
                            @error('rest_end')
                            {{ $message }}
                            @enderror
                        </div>
                        <input type="text" name="breaks[{{ $loop->index }}][rest_start]" class="table-item" value="{{ substr($rest->rest_start, 0, 5) ?? '' }}"><span class="table-span">～</span>
                        <input type="text" name="breaks[{{ $loop->index }}][rest_end]" class="table-item" value="{{ substr($rest->rest_end, 0, 5) ?? '' }}">
                    </td>
                </tr>
                @endforeach
                @elseif($breaks)
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
                            @error('rest_start')
                            {{ $message }}
                            @enderror
                            @error('rest_end')
                            {{ $message }}
                            @enderror
                        </div>
                        <input type="text" name="breaks[{{ $loop->index }}][rest_start]" class="table-item" value="{{ old('breaks[{{ $loop->index }}][rest_start]') ?? substr($break->rest_start, 0, 5) ?? '' }}"><span class="table-span">～</span>
                        <input type="text" name="breaks[{{ $loop->index }}][rest_end]" class="table-item" value="{{ old('breaks[{{ $loop->index }}][rest_end]') ?? substr($break->rest_end, 0, 5) ?? '' }}">
                    </td>
                </tr>
                @endforeach
                @endif
                @if($work)
                <tr class="table__inner">
                    <th class="table-title">
                        @if($breaks === 0)
                            休憩
                        @else
                            休憩{{ count($breaks) + 1 }}
                        @endif
                    </th>
                    <td class="table-content">
                        <input type="text" name="rest[rest_start]" class="table-item"><span class="table-span">～</span>
                        <input type="text" name="rest[rest_end]" class="table-item">
                    </td>
                </tr>
                <tr class="table__inner">
                    <th class="table-title">備考</th>
                    <td class="table-content">
                        <div class="error">
                            @error('content')
                            {{ $message }}
                            @enderror
                        </div>
                        @if($apply)
                        <textarea class="table-textarea" name="content" readonly>{{ $apply->content }}</textarea>
                        @elseif($work)
                        <textarea class="table-textarea" name="content">{{ old('content') }}</textarea>
                        @endif
                    </td>
                </tr>
                @endif
            </table>
            @if($apply)
            <div class="update">
                <p class="update-p">*承認待ちのため修正はできません。</p>
            </div>
            @elseif($work)
            <div class="button">
                <button class="button__submit" type="submit">修正</button>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection