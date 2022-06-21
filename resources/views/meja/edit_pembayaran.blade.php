<?php
$total_tagihan = $dt_pembayaran->total_orderan + $dt_pembayaran->service + $dt_pembayaran->tax + $dt_pembayaran->round - $dt_pembayaran->discount - $dt_pembayaran->voucher - $dt_pembayaran->dp; ?>
<div class="row">
    <input type="hidden" id="no_order" name="no_order" value="<?= $no_order ?>">

    <div class="col-12">
        <div class="form-group">
            <label>Total Tagihan</label>
            <input type="number" class="form-control" id="total_tagihan" value="<?= $total_tagihan ?>" disabled>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Cash</label>
            <input type="number" name="cash" id="cash" value="<?= $dt_pembayaran->cash ?>"
                class="form-control input_edit_pembayaran">
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>BCA Debit</label>
            <input type="number" name="d_bca" id="d_bca" value="<?= $dt_pembayaran->d_bca ?>"
                class="form-control input_edit_pembayaran">
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>BCA Kredit</label>
            <input type="number" name="k_bca" id="k_bca" value="<?= $dt_pembayaran->k_bca ?>"
                class="form-control input_edit_pembayaran">
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Mandiri Debit</label>
            <input type="number" name="d_mandiri" id="d_mandiri" value="<?= $dt_pembayaran->d_mandiri ?>"
                class="form-control input_edit_pembayaran">
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label>Mandiri Kredit</label>
            <input type="number" name="k_mandiri" id="k_mandiri" value="<?= $dt_pembayaran->k_mandiri ?>"
                class="form-control input_edit_pembayaran">
        </div>
    </div>

</div>
