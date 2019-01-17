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
<b-dropdown variant="link" size="lg" no-caret right >
    <template slot="button-content">
        <i class="fas fa-caret-down"></i>
    </template>
    @switch(Auth::user()->role->name)
        @case('admin')
        <b-dropdown-item href="{{route('admin.accounts')}}">Účty</b-dropdown-item>
        @break
        @case('teacher')
        <b-dropdown-item href="#">Správa účtů</b-dropdown-item>
        @break
    @endswitch
    <b-dropdown-item href="{{route('account.settings')}}">Nastavení</b-dropdown-item>
    <b-dropdown-divider></b-dropdown-divider>
    <b-dropdown-item href="{{route('login.logout')}}">Odhlásit</b-dropdown-item>
</b-dropdown>