<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item mb-3">
            <a class="nav-link @if(url()->current() != route('dashboard'))collapsed @endif" href="/">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-heading">Pages</li>
        @if(Auth::user()->role == 'superadmin' or Auth::user()->role == 'administrator')
        <li class="nav-item">
            <a class="nav-link @if(url()->current() != route('employees'))collapsed @endif"
                data-bs-target="#master-data" data-bs-toggle="collapse" href="#">
                <i class="bi bi-database-fill"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master-data"
                class="nav-content collapse @if(url()->current() == route('employees') || url()->current() == route('drivers'))show @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('employees') }}">
                        <i class="bi bi-circle-fill"></i><span>Data Karyawan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('drivers') }}">
                        <i class="bi bi-circle-fill"></i><span>Data Supir</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Master Data Nav -->
        @endif
        @if (Auth::user()->userDetail->division == 'Operasional' or Auth::user()->role == 'superadmin' or
        Auth::user()->role == 'administrator')
        <li class="nav-item">
            <a class="nav-link @if(url()->current() != route('omzet'))collapsed @endif" data-bs-target="#operasional"
                data-bs-toggle="collapse" href="#">
                <i class="bi bi-truck"></i><span>Operasional</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="operasional" class="nav-content collapse @if(url()->current() == route('omzet'))show @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('omzet') }}">
                        <i class="bi bi-circle-fill"></i><span>Target Omzet</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Operasional Nav -->
        @endif

    </ul>

</aside><!-- End Sidebar-->