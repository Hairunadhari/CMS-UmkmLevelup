<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">UMKM Levelup</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">UL</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item">
                <a class="nav-link {{ '' }}" href="{{ url('home') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Kuesioner</li>
            <li class="{{ Request::is('kuesioner-unverif') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('kuesioner-unverif') }}"><i class="fas fa-user-xmark"></i> <span>List - Unverified</span></a>
            </li>
            <li class="{{ Request::is('kuesioner-verif') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('kuesioner-verif') }}"><i class="fas fa-user-check"></i> <span>List - Verified</span></a>
            </li>
            {{-- <li class="{{ Request::is('showPenjualan') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('showPenjualan') }}"><i class="fas fa-tags"></i> <span>List Penjualan</span></a>
            </li>
            <li class="{{ Request::is('dashboard-gudang') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('dashboard-gudang') }}"><i class="fas fa-sitemap"></i> <span>Tampilan Gudang</span></a>
            </li> --}}
            <li class="menu-header">Manajemen</li>
            <li class="{{ Request::is('set-level') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{url('set-level')}}"><i class="fas fa-tags"></i> <span>Setting Level</span></a>
            </li>
        
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link"
                    href="#"><i class="fas fa-user"></i> <span>User</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link"
                    href="#"><i class="fas fa-cogs"></i> <span>Hak Akses</span></a>
            </li>
        </ul>
    </aside>    
</div>
