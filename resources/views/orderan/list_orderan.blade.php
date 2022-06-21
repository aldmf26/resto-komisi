@extends('template.master')
@section('content')
    <style>
        h6 {
            color: #155592;
            font-weight: bold;
        }

    </style>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">

            </div><!-- /.container-fluid -->
        </div>
        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <a href=""></a>
                        <div class="card mb-2" style="background-color: #25C584;">
                            <div class="card-body">
                                <h3 style="text-align: center; color:white"><?= $no ?></h3>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form action="<?= route('save_transaksi') ?>" method="post" class="form_save">
                                    @csrf
                                    <input type="hidden" name="no_order" id="no_order" value="<?= $no ?>">
                                    <div id="orderan">

                                    </div>
                                </form>
                            </div>
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            load_order();

            function load_order() {
                var no_order = $("#no_order").val();
                // alert(no_order);
                $.ajax({
                    method: "GET",
                    url: "<?= route('list_order2') ?>?no=" + no_order,
                    dataType: "html",
                    success: function(hasil) {
                        $('#orderan').html(hasil);
                    }
                });
            }

            $(document).on('input', '.qty', function() {
                var detail = $(this).attr('detail');
                var qty = $(this).val();
                var harga = $(".harga" + detail).val();
                var ttl_rp = parseFloat(qty) * parseFloat(harga);
                var max = $(this).attr('max');
                var min = $(this).attr('min');

                if (qty > max) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'error',
                        title: 'Jumlah yang dimasukkan melebihi pesanan'
                    });
                }
                var number = ttl_rp.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $(".total" + detail).text(number);
                $("#total_id" + detail).val(ttl_rp);

                var ttl = $(".tl").val();
                var qty1 = 0;
                $(".qty").each(function() {
                    qty1 += parseFloat($(this).val());

                });
                var ttl_rp1 = 0;
                $(".tl").each(function() {
                    ttl_rp1 += parseFloat($(this).val());

                });
                var number2 = ttl_rp1.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $('.total_qty').text(qty1);
                $('.total_hrg').text(number2);
                $('.ttl_hrg').val(ttl_rp1);


                var a_okr = $("#a_okr").val();
                var a_ser = $("#a_ser").val();

                var batas = $("#batas").val();

                var ong = $("#ong").val();
                console.log(a_okr);

                if (ttl_rp1 < batas) {
                    if (a_okr == 'Y') {
                        var ongkir = parseFloat(ong);
                    } else {
                        var ongkir = 0;
                    }
                } else {
                    var ongkir = 0;
                }

                if (a_ser == 'Y') {
                    var service = ttl_rp1 * 0.07;
                } else {
                    var service = 0;
                }
                if (a_ser == 'Y') {
                    var tax = (ttl_rp1 + service + ongkir) * 0.1;
                } else {
                    var tax = (ttl_rp1 + ongkir) * 0.1;
                }

                var number3 = ongkir.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                var servis = service.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                var tax1 = tax.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                var servis2 = service.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1");

                $('.ongkir').text(number3);
                $('.servis').text(servis);
                $('.servis1').val(servis2);
                $('.tax').text(tax1);
                $('.tax1').val(tax);

                var total = ttl_rp1 + service + tax + ongkir;


                var a = Math.round(total);
                var a_format = a.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                var b = a_format.substr(-3);
                if (b == '000') {
                    c = a;
                    round = '000';
                } else if (b < 1000) {
                    c = a - b + 1000;
                    round = 1000 - b;
                }


                var rupiah = $("#rupiah").val();
                $('#total2').val(c);
                $('.round').val(round);
                $('#total1').val(c);

            });

            $(document).on('click', '#proses', function(event) {
                var ttl_harga = $(".ttl_hrg").val();
                var order = $(".order").val();
                var url = "<?= route('perhitungan') ?>?order=" + order + '&ttl=' + ttl_harga;
                $('#perhitungan').load(url);
            });

            $(document).on('submit', '.form_save', function(event) {
                //   event.preventDefault();

                $('.save_btn').hide();
                // $('.save_loading').show();

            });

            $(document).on('click', '#cek_voucher', function(event) {
                var kode = $('.kd_voucher').val();
                var ttl1 = $('#total1').val();
                var ttl2 = $('#total2').val();
                var view_dp = $('#view_dp').val();
                var view_discount = $('#view_discount').val()
                var gosen = $('#gosen').val();
                var ttl_hrg = $('#ttl_hrg').val();
                var ttl_hrg2 = $('#ttl_hrg2').val();

                if (kode == '') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'error',
                        title: 'Masukkan kode voucher'
                    });
                } else {
                    $.ajax({
                        url: "<?= route('voucher_pembayaran') ?>?kode=" + kode,
                        type: "GET",
                        // dataType: "json",
                        success: function(data) {
                            if (data == 'kosong') {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    icon: 'error',
                                    title: 'Kode voucher tidak ditemukan'
                                });

                            } else {
                                if (data == 'terpakai') {
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        icon: 'error',
                                        title: 'Voucher sudah terpakai'
                                    });
                                } if(data == 'expired') {
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        icon: 'error',
                                        title: 'Voucher sudah expired'
                                    });
                                } else {
                                    if (data == 'off') {
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000,
                                            icon: 'error',
                                            title: 'Voucher non-aktif'
                                        });
                                    } else {
                                        $('#rupiah').val(data);
                                        // if(parseFloat(data) >= ttl_hrg2) {
                                        //     var tot_orderan = 0;
                                        //     var service = 0;
                                        //     var tax = 0;
                                        //     var ttl = tot_orderan + service + tax - view_dp +
                                        //         parseFloat(gosen);
                                        //     var t = ttl - ((ttl * view_discount) / 100)
                                        
                                        // } else {
                                        //     var tot_orderan = ttl_hrg - data;
                                        //     var service = tot_orderan * 0.07;
                                        //     var tax = (tot_orderan + service) * 0.1;
                                        //     var ttl = tot_orderan + service + tax - view_dp +
                                        //         parseFloat(gosen);
                                        //     var t = ttl - ((ttl * view_discount) / 100)
                                        // }
                                        
                                        var tot_orderan = ttl_hrg - data;
                                        var service = tot_orderan * 0.07;
                                        var tax = (tot_orderan + service) * 0.1;
                                        var ttl = tot_orderan + service + tax - view_dp +
                                            parseFloat(gosen);
                                        var t = ttl - ((ttl * view_discount) / 100)

                                        $('#total1').val(t);
                                        $('.servis').html(service);
                                        $('.tax').html(tax);

                                        $('.servis1').val(service);
                                        $('.tax1').val(tax);


                                        var cash = parseInt($("#cash").val());
                                        var mandiri_kredit = parseInt($("#mandiri_kredit")
                                            .val());
                                        var mandiri_debit = parseInt($("#mandiri_debit").val());
                                        var bca_kredit = parseInt($("#bca_kredit").val());
                                        var bca_debit = parseInt($("#bca_debit").val());
                                        var total = parseInt($("#total1").val());
                                        var bayar = mandiri_kredit + mandiri_debit + cash +
                                            bca_kredit + bca_debit;
                                        // alert(mandiri_kredit);
                                        if (total <= bayar) {
                                            $('#btn_bayar').removeAttr('disabled');
                                        } else {
                                            $('#btn_bayar').attr('disabled', 'true');
                                        }


                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000,
                                            icon: 'success',
                                            title: 'Berhasil memasukkan kode voucher'
                                        });
                                    }

                                }

                            }

                        }
                    });

                }

            });
            $(document).on('click', '#btl_voucher', function(event) {
                var kode = $('.kd_voucher').val();
                var ttl1 = $('#total1').val();
                var ttl2 = $('#total2').val();
                var ttl_hrg2 = $('#ttl_hrg2').val();
                var view_dp = $('#view_dp').val();
                var view_discount = $('#view_discount').val();
                var gosen = $('#gosen').val();
                var ttl = ttl2 - view_dp + parseFloat(gosen);
                var t = ttl - ((ttl * view_discount) / 100)
                if (kode == '') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'error',
                        title: 'Masukkan kode voucher'
                    });
                } else {
                    $('.kd_voucher').val('');
                    $('#rupiah').val('');
                    $('#total1').val(t);

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'success',
                        title: 'Berhasil Membatalkan voucher'
                    });
                }

            });

            $(document).on("change", "#data_discount", function() {
                var id_discount = $(this).val();

                // alert(id_discount);
                var val1 = $("#total2").val();
                var gosen = $('#gosen').val();
                var rupiah = $('#rupiah').val();

                if (id_discount == 0) {
                    var total_bayar = val1 - rupiah + parseFloat(gosen);
                    $("#total1").val(total_bayar);
                    $("#view_discount").val(0);
                    $("#id_discount").val(0);
                } else {
                    $.ajax({
                        url: "<?= route('get_discount') ?>?id_discount=" + id_discount,
                        method: "GET",
                        dataType: "json",
                        success: function(data) {
                            $("#jumlah_discount").val(data.disc);
                            $("#jenis").val(data.jenis);

                            if (data.jenis == 'Rp') {

                                $("#id_discount").val(data.id_discount);
                                var total_bayar = val1 - rupiah + parseFloat(gosen) - parseInt(
                                    $("#jumlah_discount").val());
                                $("#total1").val(total_bayar);
                                $("#view_discount").val($("#jumlah_discount").val());
                            } else {

                                $("#id_discount").val(data.id_discount);
                                var total_bayar = val1 - rupiah + parseFloat(gosen);
                                var t = total_bayar - ((total_bayar * data.disc) / 100)
                                $("#total1").val(t);
                                $("#view_discount").val($("#jumlah_discount").val());
                            }


                        }
                    });
                }
            });

            $(document).on("change", "#data_dp", function() {
                var id_dp = $(this).val();
                // alert(id_dp);
                var val1 = $("#total2").val();
                var gosen = $('#gosen').val();
                var rupiah = $('#rupiah').val();
                if (id_dp == 0) {
                    var total_bayar = val1 - rupiah + parseFloat(gosen);
                    $("#total1").val(total_bayar);
                    $("#view_dp").val(0);
                    $("#id_dp").val(0);
                } else {
                    $.ajax({
                        url: "<?= route('get_dp') ?>?id_dp=" + id_dp,
                        method: "GET",
                        dataType: "json",
                        success: function(data) {
                            $("#jumlah_dp").val(data.jumlah);
                            $("#id_dp").val(data.id_dp);
                            var total_bayar = val1 - rupiah + parseFloat(gosen) - parseInt($(
                                "#jumlah_dp").val());
                            $("#total1").val(total_bayar);
                            $("#view_dp").val($("#jumlah_dp").val());

                        }
                    });
                }
            });
            $(document).on('keyup', '#gosen', function() {
                var gosen = $(this).val();
                var ttl2 = $("#total2").val();
                var rupiah = $('#rupiah').val();
                var view_dp = $('#view_dp').val();
                if (gosen == '') {
                    var hasil = ttl2 - rupiah - view_dp;
                } else {
                    var hasil = ttl2 - rupiah - view_dp + parseFloat(gosen);
                }
                $("#total1").val(hasil);

            });



            $(document).on('keyup', '.pembayaran', function() {
                // var diskon = parseInt($("#diskon").val());
                var cash = parseInt($("#cash").val());
                var mandiri_kredit = parseInt($("#mandiri_kredit").val());
                var mandiri_debit = parseInt($("#mandiri_debit").val());
                var bca_kredit = parseInt($("#bca_kredit").val());
                var bca_debit = parseInt($("#bca_debit").val());
                var total = parseInt($("#total1").val());
                var bayar = mandiri_kredit + mandiri_debit + cash + bca_kredit + bca_debit;
                // alert(mandiri_kredit);
                if (total <= bayar) {
                    $('#btn_bayar').removeAttr('disabled');
                } else {
                    $('#btn_bayar').attr('disabled', 'true');
                }
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
