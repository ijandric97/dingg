<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include("includes.head")
</head>
<body>
    <div id="app">  
        @include("includes.navbar")
        <main class="py-4 bg-white">
            @yield('content')
        </main>
        @include("includes.footer")
    </div>
</body>
</html>
