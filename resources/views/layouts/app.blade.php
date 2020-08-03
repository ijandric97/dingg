<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dingg') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div id="app">
        @include('includes.navbar')
        <main class="py-4 bg-gradient-light">
            @include('includes.status-alert')
            @yield('content')
        </main>
        @include('includes.footer')
    </div>
    @stack('scripts')
    <script>
        function imgError(event) {
            this.onerror = null;
            event.target.src = "{{asset('storage/images/placeholder.png')}}";
        }

        function deleteConfirm(event) {
            if (!confirm("Are you sure you want to delete?")) {
                event.preventDefault();
            }
        }
    </script>
</body>
</html>
