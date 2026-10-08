<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}

    {{-- Fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body style="background-color: #faf8f5 !important; ">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fa-solid fa-angles-right"></i>{{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        {{-- Language switch --}}
                        <div class="btn-group btn-group-sm" role="group" aria-label="Language Switcher">
                            <!-- English button -->
                            <a href="{{ route('lang.switch', 'en') }}" 
                            class="btn {{ App::getLocale() == 'en' ? 'btn-dark' : 'btn-outline-dark' }}">
                                EN
                            </a>
                            <!-- Japanese button -->
                            <a href="{{ route('lang.switch', 'ja') }}" 
                            class="btn {{ App::getLocale() == 'ja' ? 'btn-dark' : 'btn-outline-dark' }}">
                                JP
                            </a>
                        </div>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ __('Hello,') }} {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    <a href="{{ route('profile.show')}}" class="dropdown-item d-flex align-items-center">
                                        <i class="fa-solid fa-circle-user fa-fw me-2"></i> 
                                        {{ __('My profile') }}
                                    </a>

                                    <a href="{{ route('index') }}" class="dropdown-item d-flex align-items-center">
                                        <i class="fa-solid fa-box-open fa-fw me-2"></i> 
                                        {{ __('My fridge food') }}
                                    </a>

                                    <a href="{{ route('recipe.index') }}" class="dropdown-item d-flex align-items-center">
                                        <i class="fa-solid fa-file fa-fw me-2"></i> 
                                        {{ __('My recipes') }}
                                    </a>

                                    <a href="{{ route('recipe.create') }}" class="dropdown-item d-flex align-items-center">
                                        <i class="fa-solid fa-file-circle-plus fa-fw me-2"></i> 
                                        {{ __('Create a recipe') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                    {{-- Admin Controls --}}
                                    @can('admin')
                                        <hr class="dropdown-divider">
                                        <a href="{{ route('admin.users') }}" class="dropdown-item d-flex align-items-center text-danger fw-bold">
                                            <i class="fa-solid fa-user-gear fa-fw me-2"></i> {{ __('Admin') }}
                                        </a>
                                    @endcan

                                    <hr class="dropdown-divider">
                                    
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-arrow-right-from-bracket fa-fw me-2"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    {{-- Admin Controls --}}
                    @if (request()->is('admin/*') || request()->is('admin')) {{--> Display the sidebar with col-3 --}}
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="list-group shadow-sm">
                                <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action {{ request()->is('admin/users') ? 'active' : '' }}">
                                    <i class="fa-solid fa-users"></i> {{ __('Users') }}
                                </a>
                                <a href="{{ route('admin.recipes') }}" class="list-group-item list-group-item-action {{ request()->is('admin/recipes*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-laptop-file"></i> {{ __('Recipes') }}
                                </a>
                                <a href="{{ route('admin.ingredients') }}" class="list-group-item list-group-item-action {{ request()->is('admin/ingredients*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-cubes"></i> {{ __('Ingredients') }}
                                </a>
                            </div>
                        </div> 
                        <div class="col-md-9">
                            @yield('content')
                        </div>
                    @else
                        <div class="col-12">
                            @yield('content')
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
