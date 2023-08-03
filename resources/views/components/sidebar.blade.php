<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"><img src="{{asset('img/logo2.png')}}" width="25"> UMKM Levelup</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">UL</a>
        </div>
        <ul class="sidebar-menu">
            @if (Session::get('id_role') == 2)
                <li class="menu-header">Dashboard</li>
                <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link {{ '' }}" href="{{ url('home') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>
            @else
                
            @endif
            
            <li class="menu-header">Kuesioner</li>
            <li class="{{ Request::is('kuesioner-all') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('kuesioner-all') }}"><i class="fas fa-list"></i> <span>List Kuesioner</span></a>
            </li>
            <li class="{{ Request::is('kuesioner-unverif') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('kuesioner-unverif') }}"><i class="fas fa-user-xmark"></i> <span>List - Unverified</span></a>
            </li>
            <li class="{{ Request::is('kuesioner-verif') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('kuesioner-verif') }}"><i class="fas fa-user-check"></i> <span>List - Verified</span></a>
            </li>
            <li class="menu-header">Learning Sistem</li>
            <li class="{{ Request::is('list-materi') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{url('list-materi')}}"><i class="fas fa-graduation-cap"></i> <span>List Kategori Materi</span></a>
            </li>
            
            @if (Session::get('id_role') == 2)
                <li class="menu-header">Learning Sistem</li>
                {{-- <li class="{{ Request::is('list-kategori-materi') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{url('list-kategori-materi')}}"><i class="fas fa-tags"></i> <span>List Kategori Materi</span></a>
                </li> --}}
                <li class="{{ Request::is('list-materi') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{url('list-materi')}}"><i class="fas fa-graduation-cap"></i> <span>List Kategori Materi</span></a>
                </li>
                <li class="{{ Request::is('list-pengumuman') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{url('list-pengumuman')}}"><i class="fas fa-bullhorn"></i> <span>Pengumuman</span></a>
                </li>

                <li class="menu-header">Konfig & Lain</li>
                <li class="{{ Request::is('set-level') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{url('set-level')}}"><i class="fas fa-wrench"></i> <span>Setting Level</span></a>
                </li>

                <li class="{{ Request::is('import-data') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{url('import-data')}}"><i class="fas fa-upload"></i> <span>Import Data</span></a>
                </li>
            
                {{-- <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="#"><i class="fas fa-user"></i> <span>User</span></a>
                </li>

                <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="#"><i class="fas fa-cogs"></i> <span>Hak Akses</span></a>
                </li> --}}
                
                {{-- <li class="menu-header">Konfig & Lain</li>
                <li class="{{ Request::is('set-level') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{url('set-level')}}"><i class="fas fa-wrench"></i> <span>Setting Level</span></a>
                </li> --}}

            @else
                
            @endif
        </ul>
    </aside>    
</div>
