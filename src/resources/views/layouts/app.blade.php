<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    @unless(View::hasSection('hide_header'))
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                <h1>FashionablyLate</h1>
            </a>
            <div class="header__action">
                @yield('header_action')
            </div>
        </div>
    </header>
    @endunless

    <main>
        @yield('content')
    </main>
</body>

</html>