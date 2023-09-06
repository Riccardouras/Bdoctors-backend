<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/LogoPiccolo.png') }}" alt="logo" />
    <title>B-Doctors</title>

    {{-- <link rel="stylesheet" href="/resources/scss/app.scss"> --}}

    <!-- Fontawesome 6 cdn -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css'
        integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=='
        crossorigin='anonymous' referrerpolicy='no-referrer' />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">

        <div class="container-fluid vh-100">
            <div class="row h-100">
                <nav id="sidebarMenu"
                    class="col-md-3 col-lg-2 d-md-block navbar-dark sidebar collapse fixed-top h-100 bg_color">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">

                            <li class="nav-item">
                                <a target="_blank" class="nav-link text-white" href="/">
                                    <i class="fa-solid fa-home-alt fa-lg fa-fw"></i>
                                    <span class="d_none">Vai al sito</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.doctors.index' ? 'bg_primary' : '' }}"
                                    href="{{ route('admin.doctors.index') }}">
                                    <i class="fa-solid fa-user-doctor fa-lg fa-fw"></i>
                                    <span class="d_none">Home</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.sponsorship.form' ? 'bg_primary' : '' }}"
                                    href="{{ route('admin.sponsorship.form') }}">
                                    <i class="fa-lg fa-fw fa-brands fa-shopify"></i>
                                    <span class="d_none">Premium</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.doctors.stats' ? 'bg_primary' : '' }}"
                                    href="{{ route('admin.doctors.stats') }}">
                                    <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i>
                                    <span class="d_none">Statistiche</span>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.doctors.messages' ? 'bg_primary' : '' }}"
                                    href="{{ route('admin.doctors.messages') }}">
                                    <i class="fa-solid fa-message fa-lg fa-fw"></i>
                                    <span class="d_none">Messaggi</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.doctors.reviews' ? 'bg_primary' : '' }}"
                                    href="{{ route('admin.doctors.reviews') }}">
                                    <i class="fa-solid fa-comment fa-lg fa-fw"></i> <span
                                        class="d_none">Recensioni</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-sign-out-alt fa-lg fa-fw"></i>
                                    <span class="d_none">{{ __('Logout') }}</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </ul>

                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    @yield('content')
                </main>
            </div>
        </div>

    </div>
</body>

</html>
