<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white"
            style=" background:#197dab; color: #787878;">
            <div class="container">
                @php
                    if (Session::get('id_lokasi') == 1) {
                        $gambar = 'Takemori_new.jpg';
                        $h5 = 'TAKEMORI';
                    } elseif (Session::get('id_lokasi') == 2) {
                        $gambar = 'soondobu.jpg';
                        $h5 = 'SOONDOBU';
                    } else {
                        $gambar = 'user copy.png';
                        $h5 = 'ADMINISTRATOR';
                    }
                @endphp
                <img src="{{ asset('assets') }}/pages/login/img/{{ $gambar }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8"> &nbsp;
                <h5 style="font-weight: bold; color:white">{{ $h5 }}</h5>
                <button class="order-1 navbar-toggler first-button" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <div class="animated-icon1"><span></span><span></span><span></span></div>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">


                    </ul>
                </div>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ @Auth::user()->nama }} <i class="fas fa-user"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"
                            style="left: 0px; right: inherit;">
                            <a class="dropdown-item" href="#">Ganti Password</a>
                            <a class="dropdown-item" href="{{ route('logout' . @$logout) }}">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
