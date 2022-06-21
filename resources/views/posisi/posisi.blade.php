@extends('template.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 justify-content-center">
                    <div class="col-sm-12">




                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="content">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-left">Posisi</h5>
                                <a href="" data-toggle="modal" data-target="#tambah"
                                    class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Tambah Status</a>
                            </div>
                            @include('flash.flash')
                            <div class="card-body">
                                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table dataTable no-footer" id="table" role="grid"
                                                aria-describedby="table_info">

                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Posisi</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($posisi as $s)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $s->nm_posisi }}</td>
                                                            <td style="white-space: nowrap;">
                                                                <a href="" data-toggle="modal"
                                                                    data-target="#edit_data{{ $s->id_posisi }}"
                                                                    id_menu="1" class="btn edit_menu btn-new"
                                                                    style="background-color: #F7F7F7;"><i
                                                                        style="color: #B0BEC5;"><i
                                                                            class="fas fa-edit"></i></a>
                                                                <a onclick="return confirm('Apakah ingin dihapus ?')"
                                                                    href="{{ route('deletePosisi', ['id_posisi' => $s->id_posisi]) }}"
                                                                    class="btn  btn-new"
                                                                    style="background-color: #ff0000;">
                                                                    <i style="color: #B0BEC5;"><i
                                                                            class="fas fa-trash-alt"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>
    </div>
    <form action="{{ route('addPosisi') }}" method="post">
        @csrf
        <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah Posisi</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">Nama Posisi</label>
                                <input required class="form-control" type="text" name="posisi">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-costume" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @foreach ($posisi as $s)
        <form action="{{ route('editPosisi') }}" method="post">
            @method('patch')
            @csrf
            <div class="modal fade" id="edit_data{{ $s->id_posisi }}" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content ">
                        <div class="modal-header btn-costume">
                            <h5 class="modal-title text-light" id="exampleModalLabel">Edit Posisi</h5>
                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <input type="hidden" name="id_posisi" value="{{ $s->id_posisi }}">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="">Nama Posisi</label>
                                    <input class="form-control" type="text" value="{{ $s->nm_posisi }}" name="posisi">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-costume" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
