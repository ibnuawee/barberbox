<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">BarberBox</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">BX</a>
    </div>

    <ul class="sidebar-menu">
        @section('sidebar')
        <li class="menu-header">Dashboard</li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="index-0.html">General Dashboard</a></li>
                <li><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li>
            </ul>
        </li>

        @can('index-user')
        <li class="nav-item dropdown">
            <a href="{{route('user.index')}}" class="nav-link"><i class="fas fa-users"></i><span>User List</span></a>
        </li>
        @endcan

        @can('admin-saldo')
        <li class="nav-item dropdown">
            <a href="{{route('saldoAdmin.index')}}" class="nav-link"><i class="fas fa-users"></i><span>Riwayat Saldo</span></a>
        </li>
        @endcan

        @can('barber-booking')
        <li class="nav-item dropdown">
            <a href="{{route('barber.index')}}" class="nav-link"><i class="fas fa-users"></i><span>Kelola Booking</span></a>
        </li>
        @endcan

        @can('barber-schedule')
        <li class="nav-item dropdown">
            <a href="{{route('barber.setSchedule')}}" class="nav-link"><i class="fas fa-users"></i><span>Kelola Jadwal</span></a>
        </li>
        @endcan

        @can('barber-price')
        <li class="nav-item dropdown">
            <a href="{{route('barber.setPrice')}}" class="nav-link"><i class="fas fa-users"></i><span>Kelola Harga</span></a>
        </li>
        @endcan

        @can('barber-saldo')
        <li class="nav-item dropdown">
            <a href="{{route('saldoBarber.index')}}" class="nav-link"><i class="fas fa-users"></i><span>Riwayat saldo</span></a>
        </li>
        @endcan

        @can('index-article')
        <li class="nav-item dropdown">
            <a href="{{route('articles.index')}}" class="nav-link"><i class="fas fa-users"></i><span>Kelola Artikel</span></a>
        </li>
        @endcan

        @can('kelola-topup')
        <li class="nav-item dropdown">
            <a href="{{route('topups.admin_index')}}" class="nav-link"><i class="fas fa-users"></i><span>Kelola Toup</span></a>
        </li>
        @endcan

        @show
    </ul>

    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fas fa-rocket"></i> Documentation
        </a>
    </div>
</aside>