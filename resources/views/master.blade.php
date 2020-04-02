<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-language"></i>
            {{ config('app.name') }}
        </a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="https://kilowhat.net/">
                        Back to KILOWHAT homepage
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    @yield('content')
</main>

<footer class="text-center text-muted">
    <p>This is an <a href="https://github.com/kilowhat/flarum-premium-translations">open-source</a> app powered by
        Laravel and the GitHub API.</p>
</footer>

@include('analytics')
</body>
</html>
