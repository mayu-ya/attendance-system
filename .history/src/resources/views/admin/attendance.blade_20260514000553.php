@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/attendance.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content-item">
        <div class="title">
            <h2 class="title-item"></h2>
        </div>

        <form action="" class="form">
            @csrf
            <table class="table">
                <tr class="table__inner">
                    <th class="table title"></th>
                </tr>
                <tr class="table__inner">
                    <td class="table-td"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
@endsection