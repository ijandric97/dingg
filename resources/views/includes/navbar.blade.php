@can('is-admin') {{-- Display message if we are in Admin Mode--}}
<div class="bg-gradient-dark text-danger text-center" role="alert">
    ADMINISTRATOR MODE - BE CAREFUL!
</div>
@endcan
<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary border-bottom border-2 border-orange">
    <div class="container">
        <!-- Dingg "logo" -->
        <a class="navbar-brand font-weight-bold" href="{{ route("home") }}">
            {{ config('app.name', 'Dingg') }}
        </a>

        <!-- Toggle Hamburger -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Search Bar -->
            <form class="form-inline ml-auto my-auto">
                <input class="form-control mt-2 mt-sm-0 border-no-right border-secondary" type="search" placeholder="Pizza place..." style="border-radius: 0.25rem 0 0 0.25rem;">
                <button class="btn btn-light btn-outline-secondary my-2 my-sm-0" type="submit" style="border-radius: 0 0.25rem 0.25rem 0;">Search</button>
            </form>

            <!-- User / Login Section -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item active dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

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
