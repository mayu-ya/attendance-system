<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理システム</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            @if (Auth::guard('admin')->check())
            <a href="/admin/attendance/list" class="header-a">
                <img src="{{ asset('img/header-logo.png') }}" alt="COACHTECHロゴ" class="header__logo">
            </a>
            @elseif(Auth::guard('web')->check())
            <a href="/attendance" class="header-a">
                <img src="{{ asset('img/header-logo.png') }}" alt="COACHTECHロゴ" class="header__logo">
            </a>
            @else
            <img src="{{ asset('img/header-logo.png') }}" alt="COACHTECHロゴ" class="header__logo">
            @endif
        </div>
        <div class="nav">
            <nav class="header-nav">
                @if (Auth::guard('admin')->check())
                <li class="header-nav__item">
                    <a href="{{ route('admin_attendance.index') }}" class="header-nav__link">勤怠一覧</a>
                </li>
                <li class="header-nav__item">
                    <a href="{{ route('admin_staff.index') }}" class="header-nav__link">スタッフ一覧</a>
                </li>
                <li class="header-nav__item">
                    <a href="{{ route('admin_wait.index') }}" class="header-nav__link">申請一覧</a>
                </li>
                <li class="header-nav__item">
                    <form action="{{ route('admin.logout') }}" method="post">
                        @csrf
                        <button class="header-nav__button" type="submit">ログアウト</button>
                    </form>
                </li>
                @elseif(Auth::guard('web')->check()) 
                <li class="header-nav__item">
                    <a href="/attendance" class="header-nav__link">勤怠</a>
                </li>
                <li class="header-nav__item">
                    <a href="{{ route('attendance.index') }}" class="header-nav__link">勤怠一覧</a>
                </li>
                <li class="header-nav__item">
                    <form action="{{ route('apply.index') }}" class="form">
                        @csrf
                        <input type="hidden" name="action" value="wait" method="post">
                        <button class="button">申請</button>
                    </form>
                </li>
                <li class="header-nav__item">
                    <a href="" class="header-nav__link">レポート</a>
                </li>
                <li class="header-nav__item">
                    <form action="/logout" method="post">
                        @csrf
                        <button class="header-nav__button" type="submit">ログアウト</button>
                    </form>
                </li>
                @endif
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>