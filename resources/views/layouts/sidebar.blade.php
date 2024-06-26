<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">BarberBox</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">BX</a>
    </div>

    <ul class="sidebar-menu">
        @can('dashboard-barber')
        @section('sidebar')
        <li class="menu-header">Dashboard</li>
        <li class="nav-item dropdown">
            <a href="{{route('barber.dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
        </li>
        @endcan

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
        <li class="menu-header">Kelola Booking</li>
        <li class="nav-item dropdown">
            <a href="{{route('barber.index')}}" class="nav-link"><i class="fas fa-address-book"></i><span>Kelola Booking</span></a>
        </li>
        @endcan

        @can('barber-schedule')
        <li class="menu-header">Kelola Jadwal</li>
        <li class="nav-item dropdown">
            <a href="{{route('barber.setSchedule')}}" class="nav-link"><i class="fas fa-calendar-week"></i><span>Kelola Jadwal</span></a>
        </li>
        @endcan

        @can('barber-price')
        <li class="menu-header">Kelola Harga</li>
        <li class="nav-item dropdown">
            <a href="{{route('barber.setPrice')}}" class="nav-link"><i class="fas fa-money-bill-wave"></i><span>Kelola Harga</span></a>
        </li>
        @endcan

        @can('barber-saldo')
        <li class="menu-header">Riwayat Saldo</li>
        <li class="nav-item dropdown">
            <a href="{{route('saldoBarber.index')}}" class="nav-link"><i class="fas fa-comment-dollar"></i><span>Riwayat saldo</span></a>
        </li>
        @endcan

        @can('barber-laporan')
        <li class="menu-header">Laporan</li>
        <li class="nav-item dropdown">
            <a href="{{route('barber.report')}}" class="nav-link"><i class="fas fa-comment-dollar"></i><span>Laporan</span></a>
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

    {{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fas fa-rocket"></i> Documentation
        </a>
    </div> --}}
</aside>