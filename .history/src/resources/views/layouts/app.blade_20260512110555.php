<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="" class="header-a">
                <img src="{{ asset('img/header-logo') }}" alt="" class="header__logo">
            </a>
        </div>
        <div class="header-nav">
            <nav>
                <li class="header-nav__item">
                    <a href="" class="header-nav__link">勤怠一覧</a>
                </li>
                <li class="header-nav__item">
                    <a href="" class="header-nav__link">スタッフ一覧</a>
                </li>
                <li class="header-nav__item">
                    <a href="" class="header-nav__link"></a>
                </li>
                <li class="header-nav__item">
                    <a href="" class="header-nav__link">申請一覧</a>
                </li>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>