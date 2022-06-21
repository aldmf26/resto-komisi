@extends('template.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 justify-content-center">
                    <div class="col-sm-12">
                        <center>
                            <h4 style="color: #787878; font-weight: bold;">Dashboard</h4>
                        </center>

                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
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
        <div class="content">

            <div class="card">
                <center>
                    <img width="30%" src="{{ asset('assets') }}/pages/login/img/{{ $gambar }}" alt="">
                </center>
            </div>
        </div>
    </div>
@endsection
