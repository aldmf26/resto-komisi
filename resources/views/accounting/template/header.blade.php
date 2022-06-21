<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
        
            <img class="animation__wobble" src="{{asset('assets')}}{{Request::get('acc') == 1 ? '/menu/img/Takemori.svg' : '/menu/img/soondobu.jpg'}}" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <a class="btn btn-md "><b>{{ Session::get('nama') }}</b></a>
                <a href="{{ route('accounting') }}" class="btn btn-md btn-secondary justify-content-right">HOME</a>
            </ul>


        </nav>
        <!-- /.navbar -->
