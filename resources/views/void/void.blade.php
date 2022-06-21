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
            <div class="container">
                <div class="row mb-2 justify-content-center">
                    <div class="col-sm-12">
                        <center>
                            <h4 style="color: #787878; font-weight: bold;">List Void</h4>
                        </center>

                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <!-- <a class="btn btn-info float-right" data-toggle="modal" data-target="#view"><i class="fas fa-eye"></i> View</a> -->
                        <br>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <table class="table  " id="table" width="100%" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 12px;">No</th>
                                            <th style="font-size: 12px;">Tanggal</th>
                                            <th style="font-size: 12px;">No Order</th>
                                            <th style="font-size: 12px;">Table</th>
                                            <th style="font-size: 12px;">Menu</th>
                                            <th style="font-size: 12px;">Qty</th>
                                            <th style="font-size: 12px;">Harga</th>
                                            <th style="font-size: 12px;">Time Order</th>
                                            <th style="font-size: 12px;">Server</th>
                                            <th style="font-size: 12px;">Koki</th>
                                            <th style="font-size: 12px;">Waitress</th>
                                            <th style="font-size: 12px;">Time Delay</th>
                                            <th style="font-size: 12px;">Ket Void</th>
                                            <th style="font-size: 12px;">Nama void</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                    foreach ($tb_order as $t) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= date('d-m-Y', strtotime($t->tgl)) ?></td>
                                            <td><?= $t->no_order ?></td>
                                            <td><?= $t->nm_meja ?></td>
                                            <td><?= $t->nm_menu ?></td>
                                            <td><?= $t->qty ?></td>
                                            <td><?= number_format($t->qty * $t->harga, 0) ?></td>
                                            <?php $waktu1 = new DateTime($t->j_mulai); ?>
                                            <td><?= $waktu1->format('h.i A') ?></td>
                                            <td><?= $t->admin ?></td>
                                            <td style="white-space: nowrap;">
                                                <?= $t->koki1 ?>,<?= $t->koki2 ?>,<?= $t->koki3 ?></td>
                                            <td><?= $t->pengantar ?></td>
                                            <td><?= number_format($t->selisih, 0) ?> menit</td>
                                            <td><?= $t->alasan ?></td>
                                            <td><?= $t->nm_void ?></td>
                                        </tr>
                                        <?php endforeach ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <form action="<?= route('order1') ?>" method="get">
                        <div class="modal fade" id="view">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h4 class="modal-title">View</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <label for="">Dari</label>
                                                    <input type="date" name="tgl" class="form-control">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="">Sampai</label>
                                                    <input type="date" name="tgl2" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" target="_blank">Lanjutkan</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>



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
