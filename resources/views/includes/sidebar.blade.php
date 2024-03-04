<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #0C2D57 !important">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 448 512">
                <path fill="#ffffff"
                    d="M0 80C0 53.5 21.5 32 48 32h96c26.5 0 48 21.5 48 48v96c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80zM64 96v64h64V96H64zM0 336c0-26.5 21.5-48 48-48h96c26.5 0 48 21.5 48 48v96c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V336zm64 16v64h64V352H64zM304 32h96c26.5 0 48 21.5 48 48v96c0 26.5-21.5 48-48 48H304c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48zm80 64H320v64h64V96zM256 304c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s7.2 16 16 16h32c8.8 0 16-7.2 16-16s7.2-16 16-16s16 7.2 16 16v96c0 8.8-7.2 16-16 16H368c-8.8 0-16-7.2-16-16s-7.2-16-16-16s-16 7.2-16 16v64c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V304zM368 480a16 16 0 1 1 0-32 16 16 0 1 1 0 32zm64 0a16 16 0 1 1 0-32 16 16 0 1 1 0 32z" />
            </svg>
        </div>
        <div class="sidebar-brand-text mx-3">Simonas</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
        <a class="nav-link nav-link-item" href="{{ url('/') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Absensi</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="buttons.html">Masuk</a>
                <a class="collapse-item" href="cards.html">Pulang</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ Request::is('/siswa') ? 'active' : '' }}">
        <a class="nav-link nav-link-item" href="{{ url('/') }}">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>Data Siswa</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('/orang-tua') ? 'active' : '' }}">
        <a class="nav-link nav-link-item" href="{{ url('/') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Data Orang Tua</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('/riwayat-absen') ? 'active' : '' }}">
        <a class="nav-link nav-link-item" href="{{ url('/') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat Absensi</span>
        </a>
    </li>

    <hr class="sidebar-divider my-0">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-4">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
