<style>
    .invoice {
        margin: auto;
        width: 87mm;
        background: #FFF;
    }

</style>
<div class="invoice">
    <center>
        <?php if(Session::get('id_lokasi') == 1) { ?>
        <img width="100" src="{{ asset('assets') }}/pages/login/img/Takemori_new.jpg" alt="">
        <h3 align="center" style="margin-top: -1px;">TAKEMORI</h3>
        <?php } else { ?>
        <img width="100" src="{{ asset('assets') }}/pages/login/img/soondobu.jpg" alt="">
        <h3 align="center" style="margin-top: -1px;">SOONDOBU</h3>
        <?php } ?>

    </center>
    <p style="font-size: 20px;" align="center" style="margin-top: -10px;">Jl. M.T. Haryono No.16, Hotel Aria Barito
        Lantai 1</p>
    <p style="font-size: 20px;" align="center" style="margin-top: -10px;">081151-88779</p>
    <hr>
    <table width="100%">
        <tr>
            <td>
                #<?= substr($no, 5) ?><br><br>
                <?= Auth::user()->nama ?>
            </td>
            <td>

                Pax<br><br>
                <?= $pesan_2[0]->orang ?>
            </td>
            <td>
            <td style="text-align: right;"> <?= $pesan_2[0]->nm_meja ?></td>
            </td>
        </tr>
    </table>

    <hr>

    <table width="100%">
        <?php
        $s_total = 0;
        $qty = 0;
        $harga = 0;
        foreach ($order  as $d) :
            $s_total += $d->harga * $d->qty_produk;
            $qty = $d->qty_produk;
            $harga += $d->harga;
            $dis = $d->id_distribusi;
        ?>
        <tr>
            <td style="text-align: left;" width="6%"><?= $d->qty_produk ?></td>
            <td style="font-size: 20px;">
                <?= ucwords(strtolower($d->nm_menu)) ?>
            </td>
            <td width="23%" style="font-size: 20px;">
                <?= number_format($d->harga * $d->qty_produk) ?>
            </td>

            <td width="15%" align="right" style="white-space: nowrap;">
                <?= $d->selisih . ' / ' . $d->selisih2 ?>
            </td>
        </tr>
        <?php endforeach ?>
        <?php $tb_dis = DB::table('tb_distribusi')
            ->where('id_distribusi', $dis)
            ->first(); ?>
    </table>
    <table width="100%">
        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px;"></td>
            <td style="font-weight: bold;" width="22%"></td>
            <td width="15%" align="right"></td>
        </tr>
        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px;">
                <span style="font-weight: bold;"> SUBTOTAL </span>
            </td>
            <td style="font-weight: bold; font-size: 20px; text-align:center;" width="8%">
                <?= number_format($s_total) ?>
            </td>

            <td width="15%" align="right">

            </td>
        </tr>
        <?php if ($tb_dis->service == 'Y') : ?>
        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px;">
                Service Charge
            </td>
            <td width="22%" style="font-size: 20px;">
                <?= number_format($transaksi->service, 0) ?>
            </td>

            <td width="15%" align="right">

            </td>
        </tr>
        <?php else : ?>
        <?php endif ?>
        <?php if ($tb_dis->ongkir == 'Y') : ?>
        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px;">
                Ongkir
            </td>
            <td width="22%" style="font-size: 20px;">
                <?= number_format($transaksi->ongkir, 0) ?>
            </td>

            <td width="15%" align="right">

            </td>
        </tr>
        <?php else : ?>
        <?php endif ?>

        <?php if ($tb_dis->tax == 'Y') : ?>
        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px;">
                TAX
            </td>
            <td width="22%" style="font-size: 20px;">
                <?= number_format($transaksi->tax) ?>
            </td>

            <td width="15%" align="right">

            </td>
        </tr>
        <?php endif; ?>


        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px; font-weight: bold;">
                TOTAL
            </td>
            <td style="font-weight: bold; font-size: 20px;" width="22%">
                <?= number_format($transaksi->total_bayar) ?>
            </td>

            <td width="15%" align="right">

            </td>
        </tr>
        <!-- <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px;">
                Discount
            </td>
            <td width="22%" style="font-size: 20px;">
                0
            </td>

            <td width="15%" align="right">

            </td>
        </tr> -->
        <?php if($transaksi->voucher): ?>
        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px;">
                Voucher
            </td>
            <td width="22%" style="font-size: 20px;">
                <?= number_format($transaksi->voucher) ?>
            </td>

            <td width="15%" align="right">

            </td>
        </tr>
        <?php endif; ?>

        <?php if($transaksi->dp): ?>
        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px;">
                DP
            </td>
            <td width="22%" style="font-size: 20px;">
                <?= number_format($transaksi->dp) ?>
            </td>

            <td width="15%" align="right">

            </td>
        </tr>
        <?php endif; ?>

        <?php if($transaksi->gosen): ?>
        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px;">
                Gosend
            </td>
            <td width="22%" style="font-size: 20px;">
                <?= number_format($transaksi->gosen) ?>
            </td>

            <td width="15%" align="right">

            </td>
        </tr>
        <?php endif; ?>

        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px; font-weight: bold;">
                TOTAL TAGIHAN
            </td>
            <td style="font-weight: bold; font-size: 20px;" width="22%">
                <?= number_format($transaksi->total_bayar - $transaksi->voucher - $transaksi->dp + $transaksi->gosen, 0) ?>
            </td>

            <td width="15%" align="right">

            </td>
        </tr>
        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px;">
                <?php if (empty($transaksi->cash)) : ?>
                <?php else : ?>
                Cash <div style="margin-top: 5px;"></div>
                <?php endif ?>
                <?php if (empty($transaksi->d_bca)) : ?>
                <?php else : ?>
                Debit BCA <div style="margin-top: 5px;"></div>
                <?php endif ?>
                <?php if (empty($transaksi->k_bca)) : ?>
                <?php else : ?>
                Kredit BCA <div style="margin-top: 5px;"></div>
                <?php endif ?>
                <?php if (empty($transaksi->d_mandiri)) : ?>
                <?php else : ?>
                Debit MANDIRI <div style="margin-top: 5px;"></div>
                <?php endif ?>
                <?php if (empty($transaksi->k_mandiri)) : ?>
                <?php else : ?>
                Kredit MANDIRI <div style="margin-top: 5px;"></div>
                <?php endif ?>
            </td>
            <td width="22%" style="font-size: 20px;">
                <?php if (empty($transaksi->cash)) : ?>
                <?php else : ?>
                <?= number_format($transaksi->cash) ?> <div style="margin-top: 5px;"></div>
                <?php endif ?>
                <?php if (empty($transaksi->d_bca)) : ?>
                <?php else : ?>
                <?= number_format($transaksi->d_bca) ?> <div style="margin-top: 5px;"></div>
                <?php endif ?>
                <?php if (empty($transaksi->k_bca)) : ?>
                <?php else : ?>
                <?= number_format($transaksi->k_bca) ?><div style="margin-top: 5px;"></div>
                <?php endif ?>
                <?php if (empty($transaksi->d_mandiri)) : ?>
                <?php else : ?>
                <?= number_format($transaksi->d_mandiri) ?> <div style="margin-top: 5px;"></div>
                <?php endif ?>
                <?php if (empty($transaksi->k_mandiri)) : ?>
                <?php else : ?>
                <?= number_format($transaksi->k_mandiri) ?> <div style="margin-top: 5px;"></div>
                <?php endif ?>
            </td>
            <td width="15%" align="right">

            </td>
        </tr>
        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px; font-weight: bold;">
                TOTAL BAYAR
            </td>
            <td style="font-weight: bold; font-size: 20px" width="22%">
                <?= number_format($transaksi->cash + $transaksi->d_bca + $transaksi->k_bca + $transaksi->d_mandiri + $transaksi->k_mandiri, 0) ?>
            </td>

            <td width="15%" align="right">

            </td>
        </tr>


        <tr>
            <td style="text-align: left;" width="6%"></td>
            <td style="font-size: 20px;">
                Change
            </td>
            <td width="22%">
                <?= number_format($transaksi->cash + $transaksi->d_bca + $transaksi->k_bca + $transaksi->d_mandiri + $transaksi->k_mandiri - $transaksi->total_bayar, 0) ?>
            </td>

            <td width="15%" align="right" style="font-size: 20px;">

            </td>
        </tr>
    </table>
    <hr>
    <?php $Weddingdate = new DateTime($pesan_2[0]->j_mulai); ?>
    <p align="center">
        <?= $Weddingdate->format('h:i a') ?><br>
        Closed <?php
date_default_timezone_set('Asia/Makassar');
echo date('M j, Y h:i a'); ?>
    </p>
    <hr>
    <p align="center"> ** Thank you. See you next time! **</p>
</div>
<!-- ======================================================== conten ======================================================= -->

<!-- ======================================================== conten ======================================================= -->
<script>
    window.print();
</script>
