<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #0C2D57 !important">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="{{ url('logo.png') }}" alt="logo" width="35px">
        </div>
        <div class="sidebar-brand-text mx-3">Simonas</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ Route::is('home') ? 'active' : '' }}">
        <a class="nav-link nav-link-item" href="{{ url('/') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('absence.in') || Route::is('absence.out') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="/" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Absensi</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('absence.in') }}">Masuk</a>
                <a class="collapse-item" href="{{ route('absence.out') }}">Pulang</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ Route::is('parent-data*') ? 'active' : '' }}">
        <a class="nav-link nav-link-item" href="{{ route('parent-data') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Data Orang Tua Siswa</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('student-data*') ? 'active' : '' }}">
        <a class="nav-link nav-link-item" href="{{ route('student-data') }}">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>Data Siswa</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('absence-history') ? 'active' : '' }}">
        <a class="nav-link nav-link-item" href="{{ route('absence-history') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat Absensi</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('violation') ? 'active' : '' }}">
        <a class="nav-link nav-link-item" href="{{ route('absence-history') }}">
            <i class="fas fa-fw fa-times-circle"></i>
            <span>Pelanggaran Siswa</span>
        </a>
    </li>

    <hr class="sidebar-divider my-0">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-4">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
