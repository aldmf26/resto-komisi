<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/footers/">
    <style>
        .card {
            border-radius: 4px;
            background: #fff;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
            transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
        }

        .card h3 {
            font-weight: 600;
        }


        @media(max-width: 990px) {
            .card {
                margin: 20px;
            }
        }

    </style>
    <style>
        :root {
            --input-padding-x: 1.5rem;
            --input-padding-y: .75rem;
        }

        a {
            color: #787878;
        }

        a:hover {
            color: #787878;
            text-decoration: underline;
        }


        .btn-custome {
            background-color: #629779;
            border-color: #629779;
            color: #fff;
            cursor: pointer;
            -webkit-transition: all ease-in .3s;
            transition: all ease-in .3s;
        }

        body {
            background-color: white;
            /* background: linear-gradient(to right, #AAD2C1, #BDEED9); */
        }

        .card-signin {
            border: 0;
            border-radius: 1rem;
            /* box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1); */
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .card-signin .card-title {
            margin-bottom: 2rem;
            font-weight: 300;
            font-size: 1.5rem;
        }

        .card-signin .card-body {
            padding: 2rem;
        }

        .form-signin {
            width: 100%;
        }

        .form-signin .btn {
            font-size: 80%;
            border-radius: 5rem;
            letter-spacing: .1rem;
            font-weight: bold;
            padding: 1rem;
            transition: all 0.2s;
        }

        .form-label-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-label-group input {
            height: auto;
            border-radius: 2rem;
        }

        .form-label-group>input,
        .form-label-group>label {
            padding: var(--input-padding-y) var(--input-padding-x);
        }

        .form-label-group>label {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: 100%;
            margin-bottom: 0;
            /* Override default `<label>` margin */
            line-height: 1.5;
            color: #495057;
            border: 1px solid transparent;
            border-radius: .25rem;
            transition: all .1s ease-in-out;
        }

        .form-label-group input::-webkit-input-placeholder {
            color: transparent;
        }

        .form-label-group input:-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-moz-placeholder {
            color: transparent;
        }

        .form-label-group input::placeholder {
            color: transparent;
        }

        .form-label-group input:not(:placeholder-shown) {
            padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
            padding-bottom: calc(var(--input-padding-y) / 3);
        }

        .form-label-group input:not(:placeholder-shown)~label {
            padding-top: calc(var(--input-padding-y) / 3);
            padding-bottom: calc(var(--input-padding-y) / 3);
            font-size: 12px;
            color: #777;
        }

        .btn-google {
            color: white;
            background-color: #ea4335;
        }

        .btn-facebook {
            color: white;
            background-color: #3b5998;
        }

        /* Fallback for Edge
-------------------------------------------------- */

        @supports (-ms-ime-align: auto) {
            .form-label-group>label {
                display: none;
            }

            .form-label-group input::-ms-input-placeholder {
                color: #777;
            }
        }

        /* Fallback for IE
-------------------------------------------------- */

        @media all and (-ms-high-contrast: none),
        (-ms-high-contrast: active) {
            .form-label-group>label {
                display: none;
            }

            .form-label-group input:-ms-input-placeholder {
                color: #777;
            }
        }

    </style>
    <style>
        .tex {
            color: #787878;
        }

        .main-footer {
            background-color: white;
            border-top: 1px solid #dee2e6;
            padding: 1rem;
            padding-bottom: 1.5rem;
            color: #fff;
        }

        .navbar {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 1.5rem 1rem;
        }

        .py-4 {
            padding-bottom: 2.5rem !important;
        }

        .bg-gradient {
            background: #26C784;
            background: -webkit-linear-gradient(to right, #115099, #26c726);
            background: linear-gradient(to right, #4d529c, #66d1a5);
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-gradient">
        <div class="container-fluid">
            <a style="font-family: sans-serif; font-weight: 900; color: white;" class="navbar-brand"
                href="#">RESTORAN</a>
        </div>
    </nav>

    <div class="container">
        <br>
        <br>
        <h5 style="color: #129A8E; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" class="text-center">
            "WHO LIKES THE SYSTEM WILL MAKE IT EASIER TO WORK"</h5>
        <div class="row">
            <div class="col-sm-4">
                <a href="{{ route('loginAdministrator') }}">
                    <div class="card card-signin my-5">
                        <div class="card-body">
                            <center>
                                <img src="{{ asset('assets') }}/menu/img/user.png" width="60%" alt="">
                            </center>
                        </div>
                        <div class="card-footer">
                            <h5 class="text-center tex">ADMNISTRATOR</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-4">
                <div class="card card-signin my-5">
                    <a href="{{ route('loginTakemori') }}">
                        <div class="card-body">
                            <center>
                                <img src="{{ asset('assets') }}/menu/img/Takemori.svg" width="80%" alt="">
                            </center>
                        </div>
                        <div class="card-footer">
                            <h5 class="text-center tex">TAKEMORI</h5>
                        </div>
                </div>
                </a>
            </div>
            <div class="col-sm-4">
                <a href="">
                    <div class="card card-signin my-5">
                        <a href="{{ route('loginSoondobu') }}">
                            <div class="card-body">
                                <center>
                                    <img src="{{ asset('assets') }}/menu/img/soondobu.jpg" width="60%" alt="">
                                </center>
                            </div>
                            <div class="card-footer">

                                <h5 class="text-center tex">SOONDOBU</h5>
                            </div>
                    </div>
                </a>
            </div>
            </a>
        </div>
    </div>
    <footer class="main-footer py-4 bg-gradient" style="color: white; text-align: center;">
        <strong>Copyright ©2020 PT. AGA FOOD </strong>
    </footer>



</body>

</html>
