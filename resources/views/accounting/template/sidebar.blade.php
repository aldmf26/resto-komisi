<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4"  style="background-color: #BEE5EB">
    @php
        $id_lokasi = Request::get('acc');
    @endphp
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets') }}{{$id_lokasi == 1 ? '/menu/img/Takemori.svg' : '/menu/img/soondobu.jpg'}}" alt="AdminLTE Logo"
            class="brand-image image-center elevation-3" style="opacity: .8">
        <h5 class="text-block text-info text-md">{{$id_lokasi == 1 ? 'Accounting Takemori' : 'Accounting Soondobu'}}</h5>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard', ['acc' => $id_lokasi]) }}"
                        class="nav-link ">
                        <i class="
                        nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>            
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Accounting
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('akun', ['acc' => $id_lokasi]) }}"
                                class="nav-link {{Request::is('akun') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Akun</p>
                            </a>
                        </li>                    
                        <li class="nav-item">
                            <a href="{{ route('neracaSaldo', ['acc' => $id_lokasi]) }}"
                                class="nav-link {{Request::is('neracaSaldo') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Neraca Saldo</p>
                            </a>
                        </li>                    
                        <li class="nav-item">
                            <a href="{{ route('jPemasukan', ['acc' => $id_lokasi]) }}"
                                class="nav-link {{Request::is('jPemasukan') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jurnal Pemasukan</p>
                            </a>
                        </li>                    
                        <li class="nav-item">
                            <a href="{{ route('jPengeluaran', ['acc' => $id_lokasi]) }}"
                                class="nav-link {{Request::is('jPengeluaran') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jurnal Pengeluaran</p>
                            </a>
                        </li>                    
                        <li class="nav-item">
                            <a href="{{ route('bukuBesar', ['acc' => $id_lokasi]) }}"
                                class="nav-link {{Request::is('bukuBesar') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Buku Besar</p>
                            </a>
                        </li>                    
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Homepage
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('lapBulanan', ['acc' => $id_lokasi]) }}"
                                class="nav-link {{Request::is('lapBulanan') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Bulanan</p>
                            </a>
                        </li>                    
                        <li class="nav-item">
                            <a href="{{ route('jPemasukan', ['acc' => $id_lokasi]) }}"
                                class="nav-link {{Request::is('jPemasukan') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cash Flow</p>
                            </a>
                        </li>                    
                        <li class="nav-item">
                            <a href="{{ route('jPengeluaran', ['acc' => $id_lokasi]) }}"
                                class="nav-link {{Request::is('jPengeluaran') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profit & Loss</p>
                            </a>
                        </li>                    
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
