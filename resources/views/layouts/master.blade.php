<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Jacob Tinston">
        <link rel="icon" href="{{ asset('favicon.png') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'First Holiday') }}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body class="master">
        <header>
            <nav class="inner">
                <a class="logo" href="/">
                    <img src="{{ asset('assets/logo.png') }}" alt="First Holiday Logo">
                </a>

                <ul class="nav-items">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/admin') }}">Admin</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Log out
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endauth
                    @endif
                </ul>
            </nav>
        </header>

        <div id="app">
            @yield('content')
        </div>

        <footer>
            <div>
                <p>Copyright &copy; First Holidays 2022</p>
            </div>
        </footer>

        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>