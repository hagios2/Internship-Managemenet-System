<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <meta http-equiv="Content-Security-Policy" content="block-all-mixed-content">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('/storage/images/logo.jpg') }}" />

    <title>{{ 'UENR Internship' }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js"></script>
    <link href="manifest.json" rel="manifest">
    <script src="{{ asset('js/firebase.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

   

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Internship App') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="/login">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="/register">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                        <li class="nav-item dropdown">

                            <a class="nav-link" href="/messages" >

                                <h4><i class="fas fa-comments"></i> {{--  <span class="badge badge-primary"><span>  --}}</h4>

                            </a>

                        </li>

                        <li class="nav-item dropdown ">

                            <a class="nav-link " href="/confirm/connections" >

                                <i class="fas fa-bell"></i> 1{{--  {!! $connectionRequests->count() > 0 ? '<span class="badge badge-primary">'. $connectionRequests->count(). '</span>' :'' !!} --}}

                            </a>

                        </li>


                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{auth()->user()->avatar }}" style="width:2rem;" class="rounded-circle" alt="">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/logout"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
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
    </div>
</body>
</html>
