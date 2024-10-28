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
            <ul id="master-data" class="nav-content collapse @if(url()->current() == route('employees'))show @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('employees') }}">
                        <i class="bi bi-circle-fill"></i><span>Data Karyawan</span>
                    </a>
                </li>
                <li>
                    <a href="icons-bootstrap.html">
                        <i class="bi bi-circle-fill"></i><span>Data Supir & Kernet</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Master Data Nav -->
        <li class="nav-item">
            <a class="nav-link @if(url()->current() != route('employees'))collapsed @endif"
                data-bs-target="#operasional" data-bs-toggle="collapse" href="#">
                <i class="bi bi-database-fill"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="operasional" class="nav-content collapse @if(url()->current() == route('employees'))show @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('employees') }}">
                        <i class="bi bi-circle-fill"></i><span>Data Karyawan</span>
                    </a>
                </li>
                <li>
                    <a href="icons-bootstrap.html">
                        <i class="bi bi-circle-fill"></i><span>Data Supir & Kernet</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Master Data Nav -->
        @endif
        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-blank.html">
                <i class="bi bi-file-earmark"></i>
                <span>Blank</span>
            </a>
        </li><!-- End Blank Page Nav -->

    </ul>

</aside><!-- End Sidebar-->