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
            <a class="nav-link @if(url()->current() != route('employees'))collapsed @endif" data-bs-target="#master"
                data-bs-toggle="collapse" href="#">
                <i class="bi bi-database-fill"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master" class="nav-content collapse @if(url()->current() == route('employees'))show @endif"
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
        <li class="nav-item">
            <a class="nav-link @if(url()->current() != route('complaint'))collapsed @endif" data-bs-target="#helpdesk"
                data-bs-toggle="collapse" href="#">
                <i class="bi bi-building-fill"></i><span>Helpdesk</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="helpdesk"
                class="nav-content collapse @if(url()->current() == route('complaint') or url()->current() == route('confirmed-complaint'))show @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('complaint') }}">
                        <i class="bi bi-circle-fill"></i><span>{{ Auth::user()->role == 'user' ? "Pengaduan" :
                            "Pengaduan Baru" }}</span>
                    </a>
                </li>
                @if (Auth::user()->role != 'user')
                <li>
                    <a href="{{ route('confirmed-complaint') }}">
                        <i class="bi bi-circle-fill"></i><span>Pengaduan Diproses</span>
                    </a>
                </li>
                @endif
                {{-- <li>
                    <a href="">
                        <i class="bi bi-circle-fill"></i><span>Riwayat Pengaduan</span>
                    </a>
                </li> --}}
            </ul>
        </li><!-- End Helpdesk Nav -->
    </ul>

</aside><!-- End Sidebar-->