<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include("includes.head")
</head>
<body class="bg-primary">
    <div id="app">
        @include("includes.navbar")
        <main class="py-4 bg-white">
            @if (session('status'))
                <div class="container">
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
        @include("includes.footer")
    </div>
    @yield('scripts')
</body>
</html>
