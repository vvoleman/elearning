<li class="nav-item">
    <a class="nav-link" href="{{route('course.dashboard')}}">{{Auth::user()->getFullname()}}
        @if(Auth::user()->hasRole('admin'))
        <i class="fas fa-crown"></i>
        @endif
    </a>
</li>
<!--
<li class="nav-item">
    <a class="nav-link" href="{{route('course.dashboard')}}">
        <i class="fas fa-bell"></i>
    </a>
</li> !-->
<li class="nav-item dropdown">
    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <i class="fas fa-caret-down"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        @switch(Auth::user()->role->name)
            @case('admin')
                <a class="dropdown-item" href="{{route('admin.accounts')}}">Účty</a>
                @break
            @case('teacher')
                <a class="dropdown-item" href="#">Správa uživatelů</a>
                @break
            @case('user')
                <a class="dropdown-item" href="#">Historie kurzů</a>
                @break
        @endswitch
        <a class="dropdown-item" href="{{route('account.settings')}}">Nastavení</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{route('login.logout')}}">Odhlásit</a>
    </div>
</li>