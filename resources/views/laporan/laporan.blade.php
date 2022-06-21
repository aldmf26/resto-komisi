@extends('template.master')
@section('content')
    <style>
        /* .icon-menu:hover{
                background: #C8BED8;
                border-radius: 50px;
            } */

        h6 {
            color: #155592;
            font-weight: bold;
        }

    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-center">
                    <div class="col-sm-12">




                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-lg-6">
                        <form action="" id="Masuk">
                            <div class="card">
                                <div class="card-header bg-gradient">
                                    <h5>Pengelolaan Data Laporan Penjualan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="">Dari</label>
                                            <input type="date" id="tgl1" class="form-control">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="">Sampai</label>
                                            <input type="date" id="tgl2" class="form-control">
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <label for="">Kategori</label>
                                            <select name="" id="kategori" class="form-control select2bs4">
                                                <option value="1">SUMMARY</option>
                                                <option value="2">PER-ITEM</option>
                                            </select>
                                        </div>

                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button class="btn bg-gradient btn-block">Lanjutkan</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div id="data-laporan">

                        </div>
                        <div id="data-item">

                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <style>
        .modal-lg-max {
            max-width: 900px;
        }

    </style>

    <div class="modal fade" id="koki_masak" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header btn-costume">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Detail koki masak</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="form_pesanan_koki_masak">

                </div>
                <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-costume" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-costume">Edit/Save</button>
                            </div> -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#Masuk").submit(function(e) {
                e.preventDefault();
                var tgl1 = $("#tgl1").val();
                var tgl2 = $("#tgl2").val();
                var kat = $("#kategori").val();
                console.log(tgl1);
                console.log(tgl2);
                console.log(kat);

                if (kat == '1') {
                    var url = "<?= route('summary') ?>?tgl1=" + tgl1 + '&tgl2=' + tgl2;
                    $('#data-laporan').show();
                    $('#data-laporan').load(url);
                    $('#data-item').hide();
                } else {
                    var url = "<?= route('item') ?>?tgl1=" + tgl1 + '&tgl2=' + tgl2;
                    $('#data-item').show();
                    $('#data-item').load(url);
                    $('#data-laporan').hide();
                }

            });

            $(document).on('click', '#btn_telat', function() {
                var tgl1 = $(this).attr('tgl1');
                var tgl2 = $(this).attr('tgl2');
                $.ajax({
                    method: "GET",
                    url: "<?= route('get_telat') ?>",
                    data: {
                        tgl1: tgl1,
                        tgl2: tgl2
                    },
                    success: function(hasil) {
                        $("#form_pesanan_koki_masak").html(hasil);
                    }
                });
            });

            $(document).on('click', '#btn_ontime', function() {
                var tgl1 = $(this).attr('tgl1');
                var tgl2 = $(this).attr('tgl2');
                $.ajax({
                    method: "GET",
                    url: "<?= route('get_ontime') ?>",
                    data: {
                        tgl1: tgl1,
                        tgl2: tgl2
                    },
                    success: function(hasil) {
                        $("#form_pesanan_koki_masak").html(hasil);
                    }
                });
            });

        });
    </script>

    <script>
        function selection() {
            var selected = document.getElementById("select1").value;
            if (selected == 0) {
                document.getElementById("input1").removeAttribute("hidden");
            } else {
                //elsewhere actions
            }
        }
    </script>
@endsection
