@extends('template.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 justify-content-center">
                    <div class="col-sm-12">

                        <h4 style="color: #787878; font-weight: bold;">Absen</h4>


                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <!-- <a href="" data-toggle="modal" data-target="#tambah" class="btn btn-info float-right"><i class="fas fa-plus"></i>Tambah Absen</a> -->
                                <br>
                                <form action="<?= route('absen') ?>" method="get">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="date" id="tglAbsen" name="tgl" value="<?= $tgl ?>"
                                                class="form-control">

                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" class="btn btn-info btn-sm">View</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div id="dt-absen">

                                </div>
                            </div>
                        </div>

                    </div>







                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            load_absen();

            function load_absen() {
                var tgl = $("#tglAbsen").val();
                // alert(tgl)
                var url = "{{ route('tabelAbsenM') }}?tgl=" + tgl
                $("#dt-absen").load(url, "data", function(response, status,
                    request) {
                    this; // dom element
                    $('#tb_absen').DataTable({

                        "bSort": true,
                        // "scrollX": true,
                        "paging": true,
                        "stateSave": true,
                        "scrollCollapse": true
                    });
                });
            }

            $(document).on('click', '.save', function(event) {
                if(!confirm('Apakah anda yakin ?')) {
                    event.preventDefault();
                } else {
                    // var id_karyawan = $("#id_karyawan").val();
                    var id_karyawan = $(this).attr('id_karyawan');
                    var tgl = $("#tgl").val();
                    var ket = $(this).attr('ket');
                    console.log(id_karyawan);
                    $.ajax({
                        type: "POST",
                        url: "<?= route('addAbsenM') ?>",
                        data: {
                            id_karyawan: id_karyawan,
                            tgl: tgl,
                            ket: ket,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data absen telah ditambahkan'
                            });
                            // var audio = document.getElementById("audio");
                            // audio.play();
                            load_absen();
                        }
                    });
                }
                
            });
            $(document).on('click', '.btn-del', function(event) {
                var id_absen = $(this).attr('id_absen');
                console.log(id_absen);
                $.ajax({
                    type: "POST",
                    url: "<?= route('deleteAbsenM') ?>",
                    data: {
                        id_absen: id_absen,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Data absen telah dihapus'
                        });
                        // var audio = document.getElementById("audio");
                        // audio.play();
                        load_absen();
                    }
                });
            });
            $(document).on('click', '.btn-edit', function(event) {
                var id_absen_edit = $(this).attr('id_absen_edit');
                var ket2 = $(this).attr('ket2');
                $.ajax({
                    type: "POST",
                    url: "<?= route('updateAbsenM') ?>",
                    data: {
                        id_absen_edit: id_absen_edit,
                        ket2: ket2,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Data absen telah diedit'
                        });
                        // var audio = document.getElementById("audio");
                        // audio.play();
                        load_absen();
                    }
                });
            });



        });
    </script>
@endsection
