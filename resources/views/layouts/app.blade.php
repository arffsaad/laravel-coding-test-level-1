<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.name', 'Laravel') }}</title>
        {{--vite--}}
        @vite(['resources/js/app.js'])
        @vite(['resources/css/app.css'])
        @vite(['resources/sass/app.scss'])
    </head>
    <body class="bg-dark">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Events</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/events">Home</a>
                        </li>
                    </ul>
                    <a href="/events/create">
                        <button class="btn btn-outline-success" type="button">New Event</button>
                    </a>
                </div>
            </div>
        </nav>
        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show m-5" role="alert">
            <strong>Success!</strong> {{ session()->get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show m-5" role="alert">
            <strong>Error!</strong> {{ session()->get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @yield('content')
    </body>
</html>