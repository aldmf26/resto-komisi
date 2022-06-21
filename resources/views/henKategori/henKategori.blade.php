@extends('template.master')
@section('content')

<div class="content-wrapper" style="min-height: 511px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2 justify-content-center">
                <div class="col-sm-12">

                    <h4 style="color: rgb(120, 120, 120); font-weight: bold; --darkreader-inline-color:#837e75;"
                        data-darkreader-inline-color="">Level Point</h4>


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
                            {{-- <a href="{{route('excel_point')}}" class="btn btn-info float-right mr-2" ><i
                                    class="fas fa-excel"></i>Export</a> --}}
                        </div>
                        <div class="card-body">
                            <table class="table " id="table">
                                <ul class="nav nav-tabs mb-2" id="custom-tabs-two-tab" role="tablist">
                                    
                                    <li class="nav-item">
                                        <a class="nav-link <?= $id_lokasi == 1 ? 'active btn-info' : '' ?>"
                                            href="<?= route('henKategori') ?>?id_lokasi=1">Takemori</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $id_lokasi == 2 ? 'active btn-info' : '' ?>"
                                            href="<?= route('henKategori') ?>?id_lokasi=2">Soondobu</a>
                                    </li>
                            
                                </ul>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Level</th>
                                        <th>Point</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($handicap as $k)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $k->handicap }}</td>
                                        <td>{{ $k->point }}</td>
                                        <td>{{ $k->ket }}</td>
                                        <td><a href="#" data-target="#edit<?= $k->id_handicap ?>" data-toggle="modal"
                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> </a>
                                        <a onclick="rerutn confirm('Apakah yakin dihapus ?)" href="{{ route('hapusHandicap', ['id_handicap' => $k->id_handicap, 'id_lokasi' => $id_lokasi]) }}" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash"></i> </a>
                                    </td>
                                    </tr>
                                    @endforeach
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
<form action="{{route('tbhHenKategori')}}" method="post" accept-charset="utf-8">
    @csrf
    <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content ">
                <div class="modal-header btn-costume">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Tambah data</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id_lokasi" value="{{ $id_lokasi }}">
                        <div class="col-lg-3">
                            <label for="">Level</label>
                           <input type="text" class="form-control" name="handicap">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Keterangan</label>
                           <input type="text" class="form-control" name="ket">
                        </div>
                        <div class="col-lg-3">
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

<?php  foreach($handicap as $t): ?>
<form action="{{route('editHenKategori')}}" method="post" accept-charset="utf-8">
    @csrf
    <div class="modal fade" id="edit<?= $t->id_handicap ?>" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content ">
                <div class="modal-header btn-costume">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Edit data</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id_lokasi" value="{{ $id_lokasi }}">
                        <input type="hidden" name="id_handicap" value="{{ $t->id_handicap }}">
                        <div class="col-lg-3">
                            <label for="">Handicap</label>
                           <input type="text" class="form-control" value="{{ $t->handicap }}" name="handicap">
                            
                        </div>
                        <div class="col-lg-6">
                            <label for="">Keterangan</label>
                           <input type="text" class="form-control" value="{{ $t->ket }}" name="ket">
                            
                        </div>
                        <div class="col-lg-3">
                            <label for="">Point</label>
                            <input required type="number" name="point" value="{{ $t->point }}" class="form-control">
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