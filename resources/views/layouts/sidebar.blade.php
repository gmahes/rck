<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @if(url()->current() != route('dashboard'))collapsed @endif" href="/">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-heading">Pages</li>
        @if(Auth::user()->role == 'superadmin' or Auth::user()->role == 'administrator' or
        Auth::user()->userDetail->position=='Admin Akuntansi')
        <li class="nav-item">
            <a class="nav-link @if(url()->current() != route('employees'))collapsed @endif"
                data-bs-target="#master-data" data-bs-toggle="collapse" href="#">
                <i class="bi bi-database-fill"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master-data" class="nav-content collapse @if(url()->current() == route('employees'))show @endif"
                data-bs-parent="#sidebar-nav">
                @if(Auth::user()->role == 'superadmin' or Auth::user()->role == 'administrator')
                <li>
                    <a href="{{ route('employees') }}">
                        <i class="bi bi-circle-fill"></i><span>Data Karyawan</span>
                    </a>
                </li>
                @endif
            </ul>
        </li><!-- End Master Data Nav -->
        @endif
        @if (Auth::user()->userDetail->division == 'Non Operasional' or Auth::user()->role == 'superadmin' or
        Auth::user()->role == 'administrator')
        <li class="nav-item">
            <a class="nav-link @if(url()->current() != route('itdocs'))collapsed @endif"
                data-bs-target="#nonoperasional" data-bs-toggle="collapse" href="#">
                <i class="bi bi-building-fill"></i><span>Helpdesk</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="nonoperasional" class="nav-content collapse @if(url()->current() == route('itdocs'))show @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('itdocs') }}">
                        <i class="bi bi-circle-fill"></i><span>Pengaduan</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Non Operasional Nav -->
        @endif

    </ul>

</aside><!-- End Sidebar-->