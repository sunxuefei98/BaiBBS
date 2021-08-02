<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BaiBBS') - Share your ideas</title>
    <meta name="description" content="@yield('description', 'BaiBBS')" />
{{--    <title>{{ config('app.name', 'BaiBBS') }}</title>--}}

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @yield('styles')

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'BaiBBS') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ active_class(if_route('topics.index')) }}"><a class="nav-link" href="{{ route('topics.index') }}">All topics</a></li>
                    <li class="nav-item {{ active_class((if_route('categories.show') && if_route_param('category', 1))) }}"><a class="nav-link" href="{{ route('categories.show', 1) }}">Share</a></li>
                    <li class="nav-item {{ active_class((if_route('categories.show') && if_route_param('category', 2))) }}"><a class="nav-link" href="{{ route('categories.show', 2) }}">Tutorials</a></li>
                    <li class="nav-item {{ active_class((if_route('categories.show') && if_route_param('category', 3))) }}"><a class="nav-link" href="{{ route('categories.show', 3) }}">Q&A</a></li>
                    <li class="nav-item {{ active_class((if_route('categories.show') && if_route_param('category', 4))) }}"><a class="nav-link" href="{{ route('categories.show', 4) }}">Announcement</a></li>
                </ul>


                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px" height="30px">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>




                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}"><i class="far fa-user mr-2"></i>Your profile</a>

                                <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}"><i class="far fa-edit mr-2"></i>Settings</a>


                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" id="logout" href="#">
                                    <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Are you sure you want to sign out?');">
                                        {{ csrf_field() }}
                                        <button class="btn btn-block btn-danger" type="submit" name="button">Log out</button>
                                    </form>
                                </a>
                            </div>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
            </div>
            </li>
            @endguest
            </ul>
        </div>
</div>
</nav>

<main class="py-4">
    @yield('content')
</main>

@include('layouts._footer')


<!-- Scripts -->

@stack('scripts')

</body>
</html>
