@extends('template.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
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

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <a href="<?= route('meja', ['id' => $dis]) ?>" class="btn btn-sm btn-warning mb-2"><i
                                class="fas fa-arrow-left"></i> Kembali</a>
                        <div class="card mb-2" style="background-color: #25C584;">
                            <div class="card-body">
                                <h3 style="text-align: center; color:white"><?= $no ?></h3>
                            </div>
                        </div>
                        <div class="alert alert-success" role="alert"><b style="color:red;"><?= $no ?></b> Sudah di bayar!
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form action="<?= route('save_transaksi') ?>" method="post">
                                    <input type="hidden" name="no_order" value="<?= $no ?>">
                                    <table class="table">
                                        <thead>
                                            <th>No</th>
                                            <th>Meja</th>
                                            <th>Nama Menu</th>
                                            <th>Qty</th>
                                            <th style="text-align: center;">Harga</th>
                                            <th>Total Harga</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                        $qty = 0;
                                        $harga = 0;
                                        $total2 = 0;
                                        foreach ($order as $o) :
                                            $qty += $o->qty_produk;
                                            $harga += $o->harga;
                                            $dis = $o->id_distribusi;
                                            $total2 += $o->qty_produk * $o->harga;
                                        ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $o->id_meja ?></td>
                                                <td><?= $o->nm_menu ?></td>
                                                <td><?= $o->qty_produk ?></td>
                                                <td><?= number_format($o->harga, 0) ?></td>
                                                <td><?= number_format($o->qty_produk * $o->harga, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                        <?php $tb_dis = DB::table('tb_distribusi')
                                            ->where('id_distribusi', $dis)
                                            ->first();
                                        
                                        ?>


                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Subtotal</td>
                                                <td></td>
                                                <td><?= $qty ?></td>
                                                <td><?= number_format($harga, 0) ?></td>
                                                <td><?= number_format($total2, 0) ?></td>
                                                <td></td>
                                            </tr>

                                            <?php if ($tb_dis->service == 'Y') : ?>
                                            <tr>
                                                <td colspan="3">Service charge</td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%"><?= number_format($transaksi->service, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <?php else : ?>
                                            <?php endif ?>
                                            <?php if ($tb_dis->ongkir == 'Y') :  ?>
                                            <tr>
                                                <td colspan="2">Ongkir </td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%"><?= number_format($transaksi->ongkir, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <?php else : ?>
                                            <?php endif ?>
                                            <?php if ($tb_dis->tax == 'Y') :  ?>
                                            <tr>
                                                <td colspan="2">Tax</td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%"><?= number_format($transaksi->tax, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <?php endif; ?>

                                            <tr>
                                                <td style="font-weight: bold; background-color: #C8E1F3; font-weight: bold;"
                                                    colspan="2">Total order</td>
                                                <td style="background-color: #C8E1F3;"></td>
                                                <td style="font-weight: bold;background-color: #C8E1F3;font-weight: bold;">
                                                    <?= $qty ?></td>
                                                <td width="20%" style="background-color: #C8E1F3;font-weight: bold;"></td>
                                                <td width="20%" style="background-color: #C8E1F3;font-weight: bold;">
                                                    <?= number_format($transaksi->total_bayar, 0) ?>
                                                </td>
                                                <td style="background-color: #C8E1F3;font-weight: bold;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Discount</td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%">0</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Voucher</td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%"><?= number_format($transaksi->voucher, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Dp</td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%"><?= number_format($transaksi->dp, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Gosend</td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%"><?= number_format($transaksi->gosen, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; background-color: #C8E1F3; font-weight: bold;"
                                                    colspan="2">Total tagihan</td>
                                                <td style="background-color: #C8E1F3;"></td>
                                                <td style="font-weight: bold;background-color: #C8E1F3;font-weight: bold;">
                                                    <?= $qty ?></td>
                                                <td width="20%" style="background-color: #C8E1F3;font-weight: bold;"></td>
                                                <td width="20%" style="background-color: #C8E1F3;font-weight: bold;">
                                                    <?= number_format($transaksi->total_bayar - $transaksi->voucher - $transaksi->dp + $transaksi->gosen, 0) ?>
                                                </td>
                                                <td style="background-color: #C8E1F3;font-weight: bold;"></td>
                                            </tr>
                                            <?php if ($transaksi->cash == '0') : ?>
                                            <?php else : ?>
                                            <tr>
                                                <td colspan="2">Cash</td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%"><?= number_format($transaksi->cash, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <?php endif ?>
                                            <?php if ($transaksi->d_bca == '0') : ?>
                                            <?php else : ?>
                                            <tr>
                                                <td colspan="2">Debit Bca</td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%"><?= number_format($transaksi->d_bca, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <?php endif ?>
                                            <?php if ($transaksi->k_bca == '0') : ?>
                                            <?php else : ?>
                                            <tr>
                                                <td colspan="2">Kredit Bca</td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%"><?= number_format($transaksi->k_bca, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <?php endif ?>
                                            <?php if ($transaksi->d_mandiri == '0') : ?>
                                            <?php else : ?>
                                            <tr>
                                                <td colspan="2">Debit Mandiri</td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%"><?= number_format($transaksi->d_mandiri, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <?php endif ?>
                                            <?php if ($transaksi->k_mandiri == '0') : ?>
                                            <?php else : ?>
                                            <tr>
                                                <td colspan="2">Kredit Mandiri</td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%"><?= number_format($transaksi->k_mandiri, 0) ?></td>
                                                <td></td>
                                            </tr>
                                            <?php endif ?>

                                            <tr>
                                                <td colspan="2">Total Bayar</td>
                                                <td></td>
                                                <td></td>
                                                <td>-</td>
                                                <td width="20%">
                                                    <?= number_format($transaksi->cash + $transaksi->d_bca + $transaksi->k_bca + $transaksi->d_mandiri + $transaksi->k_mandiri, 0) ?>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="background-color: #BCF9BC;">Uang Kembali</td>
                                                <td style="background-color: #BCF9BC;"></td>
                                                <td style="background-color: #BCF9BC;"></td>
                                                <td style="background-color: #BCF9BC;">-</td>
                                                <td style="background-color: #BCF9BC;" width="20%">
                                                    <?= number_format($transaksi->cash + $transaksi->d_bca + $transaksi->k_bca + $transaksi->d_mandiri + $transaksi->k_mandiri - $transaksi->total_bayar, 0) ?>
                                                </td>
                                                <td style="background-color: #BCF9BC;"> <a class="btn btn-sm btn-primary"
                                                        href="<?= route('print_nota', ['no' => $no]) ?>" target="_blank"><i
                                                            class="fas fa-print"></i> Print</a></td>
                                            </tr>
                                        </tbody>


                                    </table>
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
            $(document).on('click', '#cek_voucher', function(event) {
                var kode = $('.kd_voucher').val();
                var ttl1 = $('#total1').val();
                var ttl2 = $('#total2').val();
                var view_dp = $('#view_dp').val();
                var gosen = $('#gosen').val();

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
                        url: "{{ route('voucher') }}",
                        type: "POST",
                        data: {
                            kode: kode,
                            "_token": "{{ csrf_token() }}"
                        },
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
                                $('#rupiah').val(data);
                                var ttl = ttl2 - data - view_dp + parseFloat(gosen);
                                // alert(ttl);
                                $('#total1').val(ttl);
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
                    });

                }

            });
            $(document).on('click', '#btl_voucher', function(event) {
                var kode = $('.kd_voucher').val();
                var ttl1 = $('#total1').val();
                var ttl2 = $('#total2').val();
                var view_dp = $('#view_dp').val();
                var gosen = $('#gosen').val();
                var ttl = ttl2 - view_dp + parseFloat(gosen);
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
                    $('#total1').val(ttl);

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

            $('#data_dp').change(function() {
                var id_dp = $("#data_dp").val();
                // alert(id_dp);
                var val1 = $("#total2").val();
                var gosen = $('#gosen').val();
                var rupiah = $('#rupiah').val();
                if (id_dp == 0) {
                    var total_bayar = val1 - rupiah + parseFloat(gosen);
                    // alert(total_bayar);
                    $("#total1").val(total_bayar);
                    $("#view_dp").val(0);
                    $("#id_dp").val(0);
                } else {
                    $.ajax({
                        url: "<?= route('get_dp') ?>",
                        method: "POST",
                        data: {
                            id_dp: id_dp,
                            "_token": "{{ csrf_token() }}"
                        },
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

            function bayar_default() {

                // var diskon = parseInt($("#diskon").val());
                var cash = parseInt($("#cash").val());
                var mandiri_kredit = parseInt($("#mandiri_kredit").val());
                var mandiri_debit = parseInt($("#mandiri_debit").val());
                var bca_kredit = parseInt($("#bca_kredit").val());
                var bca_debit = parseInt($("#bca_debit").val());
                var total = parseInt($("#total1").val());
                var bayar = mandiri_kredit + mandiri_debit + cash + bca_kredit + bca_debit;
                if (total <= bayar) {
                    $('#btn_bayar').removeAttr('disabled');
                } else {
                    $('#btn_bayar').attr('disabled', 'true');
                }
            }
            bayar_default();

            $('.pembayaran').keyup(function() {
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
