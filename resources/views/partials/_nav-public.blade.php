<nav class="nav_menu navbar navbar-expand-md">
    <a class="navbar-brand" href="/">Projekt</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i style="color:white" class="fas fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('about') }}">O nás</a>
            </li>
            <li class="nav-item">
                @if(Auth::guest())
                    <a class="nav-link" href="{{ route('login.login') }}">Přihlášení</a>
                @endif
            </li>
        </ul>
    </div>
</nav>
