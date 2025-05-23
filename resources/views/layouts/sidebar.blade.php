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
            <ul id="master-data"
                class="nav-content collapse @if(url()->current() == route('employees') or url()->current() == route('drivers') or url()->current() == route('customers') or url()->current() == route('suppliers'))show @endif"
                data-bs-parent="#sidebar-nav">
                @if(Auth::user()->role == 'superadmin' or Auth::user()->role == 'administrator')
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
                <li>
                    <a href="{{ route('customers') }}">
                        <i class="bi bi-circle-fill"></i><span>Data Pelanggan</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('suppliers') }}">
                        <i class="bi bi-circle-fill"></i><span>Data Supplier</span>
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
            <ul id="operasional"
                class="nav-content collapse @if(url()->current() == route('omzet') or url()->current() == route('filter-omzet'))show @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('omzet') }}">
                        <i class="bi bi-circle-fill"></i><span>Target Omzet</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Operasional Nav -->
        @endif
        @if (Auth::user()->userDetail->division == 'Non Operasional' or Auth::user()->role == 'superadmin' or
        Auth::user()->role == 'administrator')
        <li class="nav-item">
            <a class="nav-link @if(url()->current() != route('xml-coretax'))collapsed @endif"
                data-bs-target="#nonoperasional" data-bs-toggle="collapse" href="#">
                <i class="bi bi-building-fill"></i><span>Non Operasional</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="nonoperasional"
                class="nav-content collapse @if(url()->current() == route('xml-coretax') or url()->current() == route('bupot') or url()->current() == route('filter-bupot'))show @endif"
                data-bs-parent="#sidebar-nav">
                <ul class="mb-2 nav-heading">Akunting</ul>
                <li>
                    <a href="{{ route('xml-coretax') }}">
                        <i class="bi bi-circle-fill"></i><span>Fitur Coretax</span>
                    </a>
                </li>
                @if (Auth::user()->userDetail->position == 'Admin Akuntansi' or Auth::user()->role == 'superadmin' or
                Auth::user()->role == 'administrator')
                <li>
                    <a href="{{ route('bupot') }}">
                        <i class="bi bi-circle-fill"></i><span>Bupot PPh</span>
                    </a>
                </li>
                @endif
            </ul>
        </li><!-- End Non Operasional Nav -->
        @endif

    </ul>

</aside><!-- End Sidebar-->