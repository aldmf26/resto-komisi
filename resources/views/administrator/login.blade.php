<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link href="{{ asset('assets') }}/plugins/adminlogin/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/adminlogin/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/adminlogin/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/login.css">
</head>

<body>
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
        <div class="container">
            <div class="card login-card">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <img src="{{ asset('assets') }}/pages/login/img/work.jpg" alt="login"
                            class="login-card-img">
  
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <p class="login-card-description">Sign into your account</p>
                            @include('flash.flash')
                            <form action="{{ route('aksiLoginAdm') }}" method="post">
                                @csrf
                                <input type="hidden" name="jenis" value="adm">
                                <div class="form-group">
                                    <label for="email" class="sr-only">Username</label>
                                    <input autofocus type="text" name="username" id="email" class="form-control"
                                        placeholder="Username">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="***********">
                                </div>
                                <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit"
                                    value="Login">
                            </form>
                            <a href="{{ route('loginAdministrator') }}" class="forgot-password-link">Kembali ke menu
                                utama</a>
                            <!-- <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/adminlogin/js/popper.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/adminlogin/js/bootstrap.min.js"></script>
</body>

</html>
