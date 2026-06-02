@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/apply_wait.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="title">
            <h2 class="title-item">申請一覧</h2>
        </div>

        <div class="content__group">
            <form action="" class="form" method="post">
                @csrf
                <input type="hidden" name="action" value="wait">
                <button class="button">承認待ち</button>
            </form>
            <form action="{{ route('apply.index') }}" class="form" method="post">
                @csrf
                <input type="hidden" name="action" value="apply">
                <button class="button">承認済み</button>
            </form>
            <div class="content-title__wait"><a href="" class="title__wait"></a></div>
            <div class="content-title"><a href="{{ route('show.index') }}" class="title-a"></a></div>
        </div>

        <div class="item">
            <table class="table">
                <tr class="table__inner">
                    <th class="table-title">状態</th>
                    <th class="table-title">名前</th>
                    <th class="table-title">対象日時</th>
                    <th class="table-title">申請理由</th>
                    <th class="table-title">申請日時</th>
                    <th class="table-title">詳細</th>
                </tr>
                @foreach($applies as $apply)
                <tr class="table__inner">
                    @php
                    $applyText = ['pending' => '承認待ち', 'approved' => '承認済み']; 
                    @endphp
                    <td class="table-td"><input type="text" class="table-input" value="{{ $applyText[$apply->status] }}" readonly></td>
                    <td class="table-td"><input type="text" class="table-input" value="{{ $apply->user->name }}" readonly></td>
                    <td class="table-td"><input type="text" class="table-input" value="{{ $apply->date }}" readonly></td>
                    <td class="table-td"><input type="text" class="table-input" value="{{ $apply->content }}" readonly></td>
                    <td class="table-td"><input type="text" class="table-input" value="{{ $apply->updated_at_formatted }}" readonly></td>
                    <td class="table-td">
                        <div class="button">
                            <a href="{{ route('detail.index', ['id' => $apply->id]) }}" class="link-a">詳細</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection