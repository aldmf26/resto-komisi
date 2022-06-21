@extends('template.master')
@section('content')

<div class="content-wrapper" style="min-height: 511px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2 justify-content-center">
                <div class="col-sm-12">

                    <h4 style="color: rgb(120, 120, 120); font-weight: bold; --darkreader-inline-color:#837e75;"
                        data-darkreader-inline-color="">Point Kerja Dll</h4>


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
                            <a href="" class="btn btn-info float-right" data-target="#tambah" data-toggle="modal"><i
                                    class="fas fa-plus"></i> Tambah data</a>
                            <a href="{{route('excel_point')}}" class="btn btn-info float-right mr-2" ><i
                                    class="fas fa-excel"></i>Export</a>
                        </div>
                        <div class="card-body">
                            <table class="table " id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Keterangan kerja</th>
                                        <th>Point</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach($tb_kerja as $t): ?>
                                    <tr>
                                        <td>
                                            <?= $i++ ?>
                                        </td>
                                        <td>
                                            <?= $t->ket ?>
                                        </td>
                                        <td>
                                            <?= $t->point ?>
                                        </td>
                                        <td><a href="#" data-target="#edit<?= $t->id_ket ?>" data-toggle="modal"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> </a>
                                            <a onclick="return confirm('Apakah yakin dihapus ?')" href="{{route('hapus_ket', ['id_ket' => $t->id_ket])}}"  class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash"></i> </a>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
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
<form action="{{route('tambah_ket')}}" method="post" accept-charset="utf-8">
    @csrf
    <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content ">
                <div class="modal-header btn-costume">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Tambah data</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <label for="">Keterangan kerja</label>
                            <input type="text" class="form-control" name="ket">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Point</label>
                            <input required type="number" name="point" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php  foreach($tb_kerja as $t): ?>
<form action="{{route('update_ket')}}" method="post" accept-charset="utf-8">
    @csrf
    <div class="modal fade" id="edit<?= $t->id_ket ?>" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content ">
                <div class="modal-header btn-costume">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Tambah data</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <label for="">Keterangan kerja</label>
                            <input type="hidden" class="form-control" name="id_ket" value="<?= $t->id_ket ?>">
                            <input type="text" class="form-control" name="ket" value="<?= $t->ket ?>">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Point</label>
                            <input required type="number" name="point" class="form-control" value="<?= $t->point ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php endforeach ?>


@endsection
@section('script')

@endsection