<nav class="nav_menu navbar navbar-expand-md">
    <a class="navbar-brand" href="/">Projekt</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i style="color:white" class="fas fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbar">
        <ul class="navbar-nav d-flex align-items-center">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('account.dashboard')}}"><i class="fas fa-home"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link">@yield('title-username')
                @if(Auth::user()->hasRole('admin'))
                    <i class="fas fa-crown"></i>
                @endif
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-caret-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Historie kurzů</a>
                    <a class="dropdown-item" href="#">Nastavení</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('login.logout')}}">Odhlásit</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
