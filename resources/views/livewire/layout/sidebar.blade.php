
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sidenav shadow-right sidenav-light">
            <div class="sidenav-menu">
                <div class="nav accordion" id="accordionSidenav">
                    <!-- Sidenav Menu Heading (Account)-->
                    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                    <div class="sidenav-menu-heading d-sm-none">Account</div>
                    <!-- Sidenav Link (Alerts)-->
                    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                    <a class="nav-link d-sm-none" href="#!">
                        <div class="nav-link-icon"><i data-feather="bell"></i></div>
                        Alerts
                        <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
                    </a>
                    <!-- Sidenav Link (Messages)-->
                    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                    <a class="nav-link d-sm-none" href="#!">
                        <div class="nav-link-icon"><i data-feather="mail"></i></div>
                        Messages
                        <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                    </a>
                    <!-- Sidenav Menu Heading (Core)-->
                    <div class="sidenav-menu-heading">Dashboard</div>
                    <!-- Sidenav Accordion (Dashboard)-->
                    <a class="nav-link {{ request()->is(auth()->user()->role.'/dashboard*') ? 'active' : '' }}"
                        href="{{ '/'.auth()->user()->role.'/dashboard' }}">
                         <div class="nav-link-icon"><i data-feather="home"></i></div>
                         Halaman Utama
                     </a>
                    @if(auth()->user()->role === 'admin')
                    <div class="sidenav-menu-heading">Paket</div>
                    <a class="nav-link {{ request()->is('admin/paket*') ? 'active' : '' }}"
                        href="{{ '/admin/paket' }}">
                        <div class="nav-link-icon"><i data-feather="package"></i></div>
                        Data Paket
                    </a>
                    <div class="sidenav-menu-heading">Membership</div>
                    <a class="nav-link {{ request()->is('admin/users*') || request()->is('admin/universitas*') ? 'active' : '' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                        <div class="nav-link-icon"><i data-feather="user"></i></div>
                        Manajemen User
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse {{ request()->is('admin/users*') || request()->is('admin/universitas*') ? 'show' : '' }}"  id="collapseDashboards" data-bs-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">

                            <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}"
                                href="{{ '/admin/users' }}">
                                Data User</a>
                                <a class="nav-link {{ request()->is('admin/universitas*') ? 'active' : '' }}"
                                    href="{{ '/admin/universitas' }}">
                                    Data Universitas</a>
                        </nav>
                    </div>
                    <a class="nav-link {{ request()->is('admin/activesessions*') ? 'active' : '' }}"
                        href="{{ '/admin/activesessions' }}">
                        <div class="nav-link-icon"><i data-feather="activity"></i></div>
                        Active Sessions
                    </a>
                    <div class="sidenav-menu-heading">App</div>

                    <a class="nav-link {{ request()->is('user/beli*') ? 'active' : '' }}"
                        href="#">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Konfigurasi
                    </a>
                    {{-- <a class="nav-link {{ request()->is('user/transaksi*') ? 'active' : '' }}"
                        href="{{ '/user/transaksi' }}">
                        <div class="nav-link-icon"><i data-feather="shopping-bag"></i></div>
                        Daftar Transaksi
                    </a> --}}
                    @endif

                    @if(auth()->user()->role === 'user')
                        <div class="sidenav-menu-heading">Pembelian</div>
                        <a class="nav-link {{ request()->is('user/beli*') ? 'active' : '' }}"
                            href="{{ '/user/beli' }}">
                            <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                            Beli Paket
                        </a>
                        <a class="nav-link {{ request()->is('user/transaksi*') ? 'active' : '' }}"
                            href="{{ '/user/transaksi' }}">
                            <div class="nav-link-icon"><i data-feather="shopping-bag"></i></div>
                            Transaksi
                        </a>

                        <div class="sidenav-menu-heading">Kelas</div>
                        {{-- <a class="nav-link" href="#">
                            <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                            Beli Kelas
                        </a> --}}
                        <a class="nav-link {{ request()->is('paket*') ? 'active' : '' }}"  href="{{'/paket'}}">
                            <div class="nav-link-icon"><i data-feather="monitor"></i></div>
                            Belajar
                        </a>
                    @endif

                    @if(in_array(auth()->user()->role, ['tutor']))
                        <div class="sidenav-menu-heading">Materi</div>
                        <a class="nav-link {{ request()->is(auth()->user()->role.'/materi*') || request()->is(auth()->user()->role.'/domain*')  ? 'active' : '' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                            <div class="nav-link-icon"><i data-feather="book"></i></div>
                            Manajemen Materi
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ request()->is(auth()->user()->role.'/materi*') || request()->is(auth()->user()->role.'/domain*') ? 'show' : '' }}"  id="collapseDashboards" data-bs-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                <a class="nav-link {{ request()->is(auth()->user()->role.'/materi*') ? 'active' : '' }}" href="{{'/'.auth()->user()->role.'/materi'}}">
                                    Materi dan Submateri
                                </a>
                                <a class="nav-link {{ request()->is(auth()->user()->role.'/domain*') ? 'active' : '' }}" href="{{'/'.auth()->user()->role.'/domain'}}">
                                    Domain dan Subdomain
                                </a>
                            </nav>
                        </div>

                        <a class="nav-link {{ request()->is(auth()->user()->role.'/paket/materi*') ? 'active' : '' }}" href="{{'/'.auth()->user()->role.'/paket/materi'}}">
                            <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                            Paket
                        </a>

                    @endif

                    @if(in_array(auth()->user()->role, ['user', 'tutor']))
                    <div class="sidenav-menu-heading">Akun</div>
                    <a class="nav-link {{ request()->is('profile*') ? 'active' : '' }}"
                        href="{{ '/profile' }}">
                        <div class="nav-link-icon"><i data-feather="settings"></i></div>
                        Pengaturan Akun
                    </a>
                   @endif


                </div>
            </div>
            <!-- Sidenav Footer-->
            <div class="sidenav-footer">
                <div class="sidenav-footer-content">
                    <div class="sidenav-footer-subtitle">Login sebagai:</div>
                    <div class="sidenav-footer-title">
                        <div x-data="{ name: '{{ auth()->user()->name }}' }"
                            x-text="name"
                            x-on:profile-updated.window="name = $event.detail.name">
                       </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>

