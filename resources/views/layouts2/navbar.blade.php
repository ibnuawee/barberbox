<a href="index.html" class="navbar-brand ms-4 ms-lg-0">
    <h1 class="mb-0 text-primary text-uppercase"><i class="fa fa-cut me-3"></i>BARBERBOX</h1>
</a>
<button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarCollapse">
    <div class="navbar-nav ms-auto p-4 p-lg-0">
        <a href="{{ route('landingpage.index') }}" class="nav-item nav-link {{ Request::routeIs('landingpage.index') ? 'active' : '' }}">Home</a>
        <a href="" class="nav-item nav-link {{ Request::routeIs('about') ? 'active' : '' }}">About</a>
        <a href="{{ route('booking.create') }}" class="nav-item nav-link {{ Request::routeIs('booking.create') ? 'active' : '' }}">Book</a>
    </div>
    @if (Auth::check())
            <div class="nav-item d-flex">
            <div class="btn btn-primary bg-dark d-none d-lg-block">
                    Rp.{{auth()->user()->balance}}
            </div>
            <a href="{{route('topups.index')}}" class="btn btn-primary  d-none d-lg-block nav-item"><i class="fa fa-plus"></i></a>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Hi, {{ Auth::user()->name }}</a>
                <div class="dropdown-menu m-0">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> Profile
                    </a>
                    <a href="{{ route('booking.index') }}" class="dropdown-item has-icon">
                        <i class="fa fa-list-alt"></i> My Booking
                    </a>
                    <a href="{{ route('transactions.index') }}" class="dropdown-item has-icon">
                        <i class="fa fa-history"></i> Riwayat Saldo
                    </a>
                    <a href="#" class="dropdown-item has-icon text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary rounded-0 py-2 px-lg-4 d-none d-lg-block">Login</a>
    @endif
</div>