<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
      window.shared ={!! json_encode([
            'signedIn' => auth()->check(),
            'user'=>auth()->user(),
        ]) !!};
    </script>
</head>

<body>
<div id="app">
    <section class="section is-marginless is-paddingless">
        <nav class="navbar has-background-white-ter" role="navigation" aria-label="main navigation">
            @include('layouts.nav')
        </nav>
    </section>
    <main class="section">
        @yield('content')
    </main>
    <flash-message message="{{session('flash')}}"></flash-message>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>