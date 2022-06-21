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
            <div class="row mb-2 ">
                <?php foreach ($order as $p) : ?>
                    <?php $no = $p->no_order ?>
                    <?php $dis = $p->id_distribusi ?>
                <?php endforeach ?>
                <?php $transaksi = $this->db->get_where('tb_transaksi', ['no_order' => $no])->row() ?>
                <div class="col-sm-12">
                    <h4 class=" mb-6 float-left">
                        DATA ORDERAN <span class="badge badge-primary "><?= word_limiter($no_meja->nm_distribusi, 1, '') ?> <?= substr($no_meja->no_order, -1, 1) ?></span>
                    </h4>
                    <?php if (empty($transaksi)) : ?>
                    <?php else : ?>
                        <a href="<?= base_url("orderan/clear/$no") ?>" class="btn btn-sm btn-info float-right "><i class="fas fa-hand-sparkles"></i> Clear up meja</a>
                    <?php endif ?>
                    <?php if (empty($transaksi)) : ?>
                        <a href="<?= base_url("Orderan/pembayaran?no=$no") ?>" id="btn_bayar" class="btn btn-sm  btn-info float-right mr-2"><i class="fas fa-dollar-sign"></i> Pembayaran</a>
                    <?php else : ?>
                        <a href="<?= base_url("Orderan/pembayaran2?no=$no") ?>" class="btn btn-sm btn-info float-right mr-2"><i class="fas fa-dollar-sign"></i> Paid</a>
                    <?php endif ?>

                    <a href="<?= base_url("orderan/bill/$no ") ?>" target="_blank" class="btn btn-sm btn-info float-right mr-2"><i class="fas fa-print"></i> Bill</a>
                    <a href="<?= base_url("orderan/checker/$no ") ?>" target="_blank" class="btn btn-sm btn-info float-right mr-2"><i class="fas fa-print"></i> Checker</a>
                    <a class="btn btn-sm btn-info float-right mr-2" data-toggle="modal" data-target="#pesan<?= $no ?>"><i class="fas fa-plus"></i> Pesanan</a>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" id="kd_meja" value="<?= $no_meja->no_order ?>">
                            <table class="table" id="table" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Menu</th>
                                        <th>Qty</th>
                                        <th>Request</th>
                                        <th>Koki</th>
                                        <?php if ($dis == '3') : ?>
                                            <th>Driver</th>
                                        <?php else : ?>
                                            <th>Waitress</th>
                                        <?php endif ?>
                                        <th>Time delay</th>
                                        <th>Status</th>
                                        <th>Void</th>
                                    </tr>
                                </thead>
                                <tbody id="orderan">

                                </tbody>
                            </table>
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
<?php foreach ($order as $o) : ?>
    <div class="modal fade" id="waitress<?= $o->id_order ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih waitress</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php foreach ($waitress as $w) : ?>
                            <div class="col-lg-2">
                                <a data-dismiss="modal" aria-label="Close" class="btn btn-info wait" kd="<?= $o->id_order ?>" nm="<?= $w->nama ?>"><?= $w->nama ?></a>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $no = $o->no_order ?>
<?php endforeach ?>
<?php foreach ($order as $o) : ?>
    <div class="modal fade" id="driver<?= $o->id_order ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Driver</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php foreach ($driver as $w) : ?>
                            <div class="col-lg-2">
                                <a data-dismiss="modal" aria-label="Close" style="white-space: nowrap; font-size: 10px;" class="btn btn-info wait btn-block" kd="<?= $o->id_order ?>" nm="<?= $w->nama ?>"><?= $w->nama ?></a>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $no = $o->no_order ?>
<?php endforeach ?>


<style>
    .modal-lg-max {
        max-width: 60%;

    }
</style>
<div class="modal fade" id="pesan<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg-max" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="">Nama Menu</label>
                        <select name="" id="" class="form-control select2bs4">
                            <option value="">--Pilih Menu--</option>
                            <?php foreach ($tb_menu as $t) : ?>
                                <option value=""><?= $t->nm_menu ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label for="">Qty</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="col-lg-2">
                        <label for="">Harga</label>
                        <input type="number" class="form-control" readonly>
                    </div>
                    <div class="col-lg-3">
                        <label for="">Request</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-lg-1">
                        <label for="">Aksi</label>
                        <a href="" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></a>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Save</button>
            </div>
        </div>
    </div>
</div>







<!-- /.control-sidebar -->



<script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        load_orderan();

        function load_orderan() {
            var kd_meja = $("#kd_meja").val();
            $.ajax({
                method: "GET",
                url: '<?= base_url() ?>orderan/get/' + kd_meja,
                dataType: "html",
                success: function(hasil) {
                    $('#orderan').html(hasil);
                }
            });
        }
        $(document).on('click', '.wait', function(event) {
            var nm = $(this).attr('nm');
            var kd = $(this).attr('kd');
            // alert();
            $.ajax({
                type: "POST",
                url: "<?= base_url('Orderan/waitress') ?>",
                data: {
                    nm: nm,
                    kd: kd
                },
                success: function(response) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'success',
                        title: 'Waitress sudah ditambahkan'
                    });
                    load_orderan();
                }
            });
        });
    });
</script>


<script>
    <?php if ($this->session->flashdata('success')) : ?>
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            icon: 'success',
            title: '<?= $this->session->flashdata('success') ?>'
        });
    <?php endif; ?>
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