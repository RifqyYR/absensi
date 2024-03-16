<nav class="navbar navbar-expand navbar-light bg-white topbar mb-2 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-black small lh-1">
                    <span style="0.7rem;">Welcome, {{ Auth::user()->name }}</span>
                </span>
                <img class="img-profile rounded-circle" src="{{ url('backend/img/undraw_profile.svg') }}">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item text-success" href="#" data-toggle="modal" data-target="#importExcelModal">
                    <i class="fas fa-download fa-sm fa-fw mr-2 text-success"></i>
                    Import Data
                </a>
                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                    Keluar
                </a>
            </div>
        </li>
    </ul>
</nav>
