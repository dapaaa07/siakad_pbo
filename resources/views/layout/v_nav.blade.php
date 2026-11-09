@php
    $user = auth()->user();
    $level = $user ? (int) $user->level : 0;
@endphp

<nav class="mt-2" aria-label="Menu Utama SIAKAD">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}" @if(request()->is('home')) aria-current="page" @endif>
        <i class="nav-icon fas fa-home" aria-hidden="true"></i>
        <p>Home</p>
      </a>
    </li>

    @if($level === 1 || $level === 4)
      <li class="nav-item">
        <a href="{{ route('dosen') }}" class="nav-link {{ request()->is('dosen*') ? 'active' : '' }}" @if(request()->is('dosen*')) aria-current="page" @endif>
          <i class="nav-icon fas fa-chalkboard-teacher" aria-hidden="true"></i>
          <p>Kelola Data Dosen</p>
        </a>
      </li>
    @endif

    @if($level === 1 || $level === 3)
      <li class="nav-item">
        <a href="{{ route('mahasiswa') }}" class="nav-link {{ request()->is('mahasiswa*') ? 'active' : '' }}" @if(request()->is('mahasiswa*')) aria-current="page" @endif>
          <i class="nav-icon fas fa-user-graduate" aria-hidden="true"></i>
          <p>Mahasiswa</p>
        </a>
      </li>
    @endif

    @if($level === 1 || $level === 2)
      <li class="nav-item">
        <a href="{{ route('user') }}" class="nav-link {{ request()->is('user*') ? 'active' : '' }}" @if(request()->is('user*')) aria-current="page" @endif>
          <i class="nav-icon fas fa-users" aria-hidden="true"></i>
          <p>User</p>
        </a>
      </li>
    @endif

    @if($level === 1)
      <li class="nav-item">
        <a href="{{ route('about') }}" class="nav-link {{ request()->is('about*') ? 'active' : '' }}" @if(request()->is('about*')) aria-current="page" @endif>
          <i class="nav-icon fas fa-university" aria-hidden="true"></i>
          <p>About</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('chart') }}" class="nav-link {{ request()->is('chart*') ? 'active' : '' }}" @if(request()->is('chart*')) aria-current="page" @endif>
          <i class="nav-icon fas fa-chart-bar" aria-hidden="true"></i>
          <p>Chart</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('invoice') }}" class="nav-link {{ request()->is('invoice*') ? 'active' : '' }}" @if(request()->is('invoice*')) aria-current="page" @endif>
          <i class="nav-icon fas fa-file-invoice" aria-hidden="true"></i>
          <p>Invoice</p>
        </a>
      </li>
    @endif

    <li class="nav-item mt-2">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="nav-link btn btn-link text-left w-100 text-light">
          <i class="nav-icon fas fa-sign-out-alt" aria-hidden="true"></i>
          <p>Logout</p>
        </button>
      </form>
    </li>
  </ul>
</nav>
