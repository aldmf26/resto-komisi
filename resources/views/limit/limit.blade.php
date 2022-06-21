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
                            <h4 style="color: #787878; font-weight: bold;">Limit</h4>
                        </center>

                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8">
                        <!-- <a class="btn btn-info float-right" data-toggle="modal" data-target="#view"><i class="fas fa-eye"></i> View</a> -->
                        <div class="card">
                            <div class="card-body">
                                <form action="<?= route('add_limit') ?>" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label for="">Menu</label>
                                                <select class="form-control select2bs4" name="id_menu"
                                                    data-placeholder="- PILIH MENU -">
                                                    <?php foreach ($menu as $m) : ?>
                                                    <option value="<?= $m->id_menu ?>"><?= $m->nm_menu ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="">Batas Limit</label>
                                                <input type="number" name="batas_limit" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary float-right mt-2">Save</button>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <table class="table  " id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Menu</th>
                                            <th>Batas Limit</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                    foreach ($limit as $d) :
                                    ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= date('d-m-Y', strtotime($d->tgl)) ?></td>
                                            <td><?= $d->nm_menu ?></td>
                                            <td><?= $d->jml_limit ?></td>
                                            <td>


                                                <a href="<?= route('hapus_limit', ['id_limit' => $d->id_limit])  ?>"
                                                    onclick="return confirm('Apakah anda yakin?')"
                                                    class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>

                                            </td>

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
