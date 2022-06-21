@extends('template.master')
@section('content')
    <style>
        h6 {
            color: #155592;
            font-weight: bold;
        }

    </style>
    <style>
        .nav-pills .nav-link.active {
            color: #fff;
            background-color: #00A549;
            box-shadow: 0px 10px 20px 0px rgba(50, 50, 50, 0.52)
        }

        .nav {
            white-space: nowrap;
            display: block !important;
            flex-wrap: nowrap;
            max-width: 100%;
            overflow-x: scroll;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch
        }

        .nav li {
            display: inline-block
        }

        input[type=number] {
            /*for absolutely positioning spinners*/
            position: relative;
            padding: 5px;
            padding-right: 25px;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            opacity: 1;
        }

        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: inner-spin-button !important;
            width: 25px;
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
        }

        .custom-scrollbar-js,
        .custom-scrollbar-css {
            height: 75px;
        }


        /* Custom Scrollbar using CSS */
        .custom-scrollbar-css {
            overflow-y: scroll;
        }

        /* scrollbar width */
        .custom-scrollbar-css::-webkit-scrollbar {
            width: 3px;
        }

        /* scrollbar track */
        .custom-scrollbar-css::-webkit-scrollbar-track {
            background: #EEE;
        }

        /* scrollbar handle */
        .custom-scrollbar-css::-webkit-scrollbar-thumb {
            border-radius: 1rem;
            background: #26C784;
            background: -webkit-linear-gradient(to right, #11998e, #26C784);
            background: linear-gradient(to right, #11998e, #26C784);
        }

        .badge-notif {
            position: relative;
        }

        .badge-notif[data-badge]:after {
            content: attr(data-badge);
            position: absolute;
            top: 3px;
            right: -2px;
            font-size: .7em;
            background: #e53935;
            color: white;
            width: 18px;
            height: 18px;
            text-align: center;
            line-height: 18px;
            border-radius: 50%;
        }
        
        .modal-lg-xl1 {
            max-width: 1000px;
        }

        .buying-selling.active {
            background-color: #CDE4D2;
        }
        @media (max-width: 400px) {
            .buying-selling {
                width: 49%;
                padding: 10px;
                position: relative;
            }
        }
        .buying-selling {
            width: 80px;
            padding: 10px;
            position: relative;
        }

    </style>
    <div class="content-wrapper" style="min-height: 511px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 justify-content-center">
                    <div class="col-sm-12">
                        <center>
                            <h4 style="color: rgb(120, 120, 120); font-weight: bold; --darkreader-inline-color:#837e75;"
                                data-darkreader-inline-color="">Orderan</h4>
                        </center>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <input type="hidden" id="id_distribusi" value="{{ $id }}">
        <input type="hidden" id="jml_order" value="0">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div id="distribusi2">

                                </div>
                            </div>
                            <div class="card-body">
                                <div id="tugas_head">

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

    <form id="tambah_pesanan_new">
        @csrf
        <div class="modal fade" id="tbh_menu" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div id="orderan">

                        </div>

                        <div id="tambah_menu_order"></div>

                        <div align="right" class="mt-2">
                            <button type="button" id="tambah_form_menu" class="btn btn-sm btn-success">+</button>
                        </div>
                        
                        @php
                                        $tgl = date('Y-m-d');
                                        $user = DB::table('users')->get();
                                        $server = DB::select("SELECT a.* , b.nama FROM tb_absen as a left join tb_karyawan as b on a.id_karyawan = b.id_karyawan
                                             WHERE a.tgl = '$tgl' and b.id_posisi = '5' and a.id_lokasi = '$loc'");
                                    @endphp
                        <div class="buying-selling-group" id="buying-selling-group" data-toggle="buttons">
                            <div class="row">
                                @php
                                    $user = DB::table('users')->get();
                                    $server = DB::select("SELECT a.* , b.nama FROM tb_absen as a left join tb_karyawan as b on a.id_karyawan = b.id_karyawan
                                        WHERE a.tgl = '$tgl' and b.id_posisi = '5' and a.id_lokasi = '$loc'");
                                @endphp
                                
                            <?php foreach ($server as $s): ?>
                                <div class="col-lg-1 mr-4">
                                <label class="btn btn-default buying-selling">
                                <div class="radio-group required">
                                    <input type="radio" required name="admin" class="" value="<?= $s->nama ?>"  autocomplete="off" class="cart_id_karyawan">
                                </div>	
                                    <span class="radio-dot"></span>
                                    <span style="white-space: nowrap" class="buying-selling-word"><?= $s->nama ?></span>
                                </label>
                                </div>
                            <?php endforeach ?>
                            </div>
                
                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary btnSave" id="btn_tambah_pesanan">Edit / Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="e_pembayaran">
        <div class="modal fade" id="edit_pembayaran" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="form_edit_pembayaran">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn_e_pembayaran">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $(document).on('submit', '#e_pembayaran', function(event) {
                event.preventDefault();
                var no_order = $("#no_order").val();
                var total_tagihan = parseInt($('#total_tagihan').val());
                var cash = parseInt($('#cash').val());
                var d_bca = parseInt($('#d_bca').val());
                var k_bca = parseInt($('#k_bca').val());
                var d_mandiri = parseInt($('#d_mandiri').val());
                var k_mandiri = parseInt($('#k_mandiri').val());

                var total_bayar = cash + d_bca + k_bca + d_mandiri + k_mandiri;
                $('#btn_e_pembayaran').hide();
                $.ajax({
                    url: `{{ route('edit_pembayaran') }}?no_order=${no_order}&cash=${cash}&d_bca=${d_bca}&k_bca=${k_bca}&d_mandiri=${d_mandiri}&k_mandiri=${k_mandiri}&total_bayar=${total_bayar}`,
                    type: 'GET',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#edit_pembayaran').hide();
                        setTimeout(function() {
                            $("[data-dismiss=modal]").trigger({
                                type: "click"
                            });
                        }, 50);
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Pembayaran berhasil diedit'
                        });

                        $('#btn_e_pembayaran').show();


                    }
                });

            });

            $(document).on('keyup', '.input_edit_pembayaran', function() {
                var total_tagihan = parseInt($('#total_tagihan').val());


                var cash = isNaN(parseInt($('#cash').val())) ? 0 : parseInt($('#cash').val());
                var d_bca = isNaN(parseInt($('#d_bca').val())) ? 0 : parseInt($('#d_bca').val());
                var k_bca = isNaN(parseInt($('#k_bca').val())) ? 0 : parseInt($('#k_bca').val());
                var d_mandiri = isNaN(parseInt($('#d_mandiri').val())) ? 0 : parseInt($('#d_mandiri')
                    .val());
                var k_mandiri = isNaN(parseInt($('#k_mandiri').val())) ? 0 : parseInt($('#k_mandiri')
                    .val());

                var total_bayar = cash + d_bca + k_bca + d_mandiri + k_mandiri;

                // console.log(total_bayar);

                if (total_tagihan <= total_bayar) {
                    $('#btn_e_pembayaran').removeAttr('disabled');
                } else {
                    $('#btn_e_pembayaran').attr('disabled', 'true');
                }
            });

            $(document).on('click', '.btn_edit_pembayaran', function() {

                var no_order = $(this).attr('no_order');



                $.ajax({
                    url: "{{ route('get_pembayaran') }}?no_order=" + no_order,
                    method: "GET",
                    success: function(data) {
                        $('#form_edit_pembayaran').html(data);

                        var total_tagihan = parseInt($('#total_tagihan').val());
                        var cash = parseInt($('#cash').val());
                        var d_bca = parseInt($('#d_bca').val());
                        var k_bca = parseInt($('#k_bca').val());
                        var d_mandiri = parseInt($('#d_mandiri').val());
                        var k_mandiri = parseInt($('#k_mandiri').val());

                        var total_bayar = cash + d_bca + k_bca + d_mandiri + k_mandiri;

                        if (total_tagihan <= total_bayar) {
                            $('#btn_e_pembayaran').removeAttr('disabled');
                        } else {
                            $('#btn_e_pembayaran').attr('disabled', 'true');
                        }

                    }
                });

            });

            $(document).on('click', '.btn_pembayaran', function() {

                var no = $(this).attr('no_order');

                $.ajax({
                    url: "{{ route('check_pembayaran') }}",
                    method: "GET",
                    data: {
                        no: no,

                    },
                    success: function(data) {
                        if (data == 'ada') {
                            window.location.href =
                                "{{ route('list_orderan') }}?no=" + no
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: 'selesaikan pesanan terlebih dahulu dengan menekan tombol <i class="text-info fas fa-thumbs-up"></i>'
                            });
                        }

                    }
                });

            });

            load_distribusi2();

            function load_distribusi2() {
                var id_distribusi = $("#id_distribusi").val();
                var jml_baru = $("#jumlah1").val();
                var jml_order = $("#jml_order").val();
                $.ajax({
                    method: "GET",
                    url: "{{ route('distribusi2') }}?id=" + id_distribusi,
                    dataType: "html",
                    success: function(hasil) {
                        $('#distribusi2').html(hasil);
                        if (jml_baru != jml_order) {
                            // console.log(`${jml_baru} : ${jml_order}`);
                            load_tugas();
                            $("#jml_order").val(jml_baru);
                        }
                    }
                });

            }
            setInterval(function() {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    data: {},
                });
                load_distribusi2();
                load_tugas();
            }, 10000);

            load_tugas();

            function load_tugas() {
                var id_distribusi = $("#id_distribusi").val();
                $.ajax({
                    method: "GET",
                    url: "{{ route('waitress') }}?dis=" + id_distribusi,
                    dataType: "html",
                    success: function(hasil) {
                        $('#tugas_head').html(hasil);
                    }
                });
            }
            $(document).on('click', '.waitress', function(event) {
                var kode = $(this).attr('kode');
                var kry = $(this).attr('kry');
                var id = $(this).attr('id_distribusi')

                // alert('behasil');
                $.ajax({
                    type: "POST",
                    url: "{{ route('pilih_waitress') }}",
                    data: {
                        kode: kode,
                        kry: kry,
                        id: id,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Waitress sudah dipilih'
                        });
                        load_tugas();
                    }
                });
            });
            $(document).on('click', '.un_waitress', function(event) {
                var kode = $(this).attr('kode');
                $.ajax({
                    type: "POST",
                    url: "{{ route('un_waitress') }}",
                    data: {
                        kode: kode,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Waitress dibatalkan'
                        });
                        load_tugas();
                    }
                });
            });
            $(document).on('click', '.selesai', function(event) {
                var kode = $(this).attr('kode');
                $.ajax({
                    type: "POST",
                    url: "{{ route('meja_selesai') }}",
                    data: {
                        kode: kode,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Makanan telah selesai'
                        });
                        load_tugas();
                    }
                });
            });
            $(document).on('click', '.gagal', function(event) {

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'error',
                    title: 'Waitress belum dipilih'
                });
                load_tugas();
            });

            $(document).on('click', '.btn_pembayaran', function() {

                var no = $(this).attr('no_order');

                $.ajax({
                    url: "<?= route('check_pembayaran') ?>",
                    method: "GET",
                    data: {
                        no: no
                    },
                    success: function(data) {
                        if (data == 'ada') {
                            window.location.href = "<?= route('list_orderan') ?>?no=" + no
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: 'selesaikan pesanan terlebih dahulu dengan menekan tombol <i class="text-info fas fa-thumbs-up"></i>'
                            });
                        }

                    }
                });

            });

            $(document).on('click', '.clear', function(event) {
                var kode = $(this).attr('kode');

                if (confirm('Apakah anda yakin ingin clear up meja?') == true) {
                    $.ajax({
                        type: "get",
                        url: "<?= route('clear') ?>?kode=" + kode,
                        success: function(response) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Meja telah di clearup'
                            });
                            load_tugas();
                        }
                    });
                    $('.scrol' + detail).hide();
                } else {
                    return false;
                }


            });

            $(document).on('click', '.btn_tbh', function() {
                var no_order = $(this).attr('no_order');
                var id_distribusi = $("#id_distribusi").val();
                // console.log(no_order);
                $.ajax({
                    url: "{{ route('tambah_pesanan') }}?no=" + no_order + "&id=" + id_distribusi,
                    dataType: "html",
                    success: function(hasil) {
                        $('#orderan').html(hasil);
                        $('.row_tambah_menu').remove();
                        $('.select2bs4').select2({
                            theme: 'bootstrap4'
                        });
                    }
                });

            });
            // Form Tambah
            var count_tambah = 1;
            $('#tambah_form_menu').click(function() {
                count_tambah = count_tambah + 1;
                // var no_nota_atk = $("#no_nota_atk").val();
                var html_code = "<div class='row mt-2 row_tambah_menu' id='row_tambah" + count_tambah +
                    "'>";

                html_code +=
                    '<div class="col-lg-4"><select name="id_harga[]" class="form-control id_harga id_harga1' +
                    count_tambah + ' select2bs4" detail="' + count_tambah +
                    '" required><option value="">-Pilih Menu-</option><?php foreach ($menu as $m) : ?><option value="<?= $m->id_harga ?>"><?= $m->nm_menu ?></option><?php endforeach ?></select></div>';

                html_code +=
                    '<div class="col-lg-2"><input type="number" name="qty[]"  value="1" min="1" class="form-control" required></div>';

                html_code +=
                    '<div class="col-lg-2"><input type="text" name="harga[]" class="form-control harga harga' +
                    count_tambah + '" detail="' + count_tambah + '" readonly></div>';

                html_code +=
                    '<div class="col-lg-3"><input type="text" name="req[]"  class="form-control"></div>';

                html_code +=
                    ' <div class="col-md-1"><button type="button" name="remove" data-row="row_tambah' +
                    count_tambah + '" class="btn btn-danger btn-sm remove_tambah_menu">-</button></div>';


                html_code += "</div>";

                $('#tambah_menu_order').append(html_code);
                $('.select2bs4').select2({
                    theme: 'bootstrap4'

                });
                $('.select2bs4').one('select2:open', function(e) {
                    $('input.select2-search__field').prop('placeholder', 'Search...');
                });
            });

            $(document).on('click', '.remove_tambah_menu', function() {
                var delete_row = $(this).data("row");
                $('#' + delete_row).remove();
            });

            $(document).on('submit', '#tambah_pesanan_new', function(event) {
                event.preventDefault();
                $('#btn_tambah_pesanan').hide();
                var kd_order = $('#kd_order').val()
                var id_dis = $('#id_dis').val()
                var orang = $('#orang').val()
                var meja = $('#meja').val()

                var id_harga = $("#id_harga").val()

                var pesanan_new = $("#tambah_pesanan_new").serialize()

                $.ajax({
                    url: "{{ route('save_pesanan_new') }}?" + pesanan_new,
                    method: 'GET',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#tbh_menu').hide();
                        setTimeout(function() {
                            $("[data-dismiss=modal]").trigger({
                                type: "click"
                            });
                        }, 50);
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Pesanan berhasil ditambahkan'
                        });
                        load_tugas();

                        $('#tambah_pesanan').trigger("reset");
                        $('.id_harga').val('');
                        $('.id_harga').trigger('change');
                        $('.row_tambah_menu').remove();

                        $('#btn_tambah_pesanan').show();


                    }
                });

            });



        });
    </script>
@endsection
