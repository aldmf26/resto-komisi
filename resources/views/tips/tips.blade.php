@extends('template.master')
@section('content')
    <div class="content-wrapper" style="min-height: 511px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 justify-content-center">
                    <div class="col-lg-12">

                    </div>

                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-left">Data Tips</h5>
                            </div>
                            <div class="card-body">
                                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table dataTable no-footer" id="table" role="grid"
                                                aria-describedby="table_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Nominal</th>
                                                        <th>Servers</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <form action="{{ route('addTips') }}" method="POST">
                                                        @csrf
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td><input required type="number" class="form-control"
                                                                    name="nominal" style="width: 200px;"
                                                                    placeholder="Masukkan nominal">
                                                            </td>
                                                            <td></td>
                                                            <td><button class="btn btn-info btn-sm">Submit</button></td>
                                                        </tr>

                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($tips as $t)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $t->tgl }}</td>
                                                            <td>{{ number_format($t->nominal,0) }}</td>
                                                            <td>{{ ucwords(Str::lower($t->admin)) }}</td>
                                                            <td>
                                                                <a href="#" data-target="#edit_data{{ $t->id_tips }}"
                                                                    data-toggle="modal" class="btn btn-sm btn-warning"><i
                                                                        class="fas fa-edit"></i></a>
                                                                <a href="{{ route('deleteTips', ['id_tips' => $t->id_tips]) }}"
                                                                    onclick="return confirm('Apakah Yakin ?')"
                                                                    class="btn btn-sm btn-danger"><i
                                                                        class="fas fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                </form>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    {{-- modal untuk edit --}}
    @foreach ($tips as $k)
        <form action="{{ route('editTips') }}" method="post" accept-charset="utf-8">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit_data{{ $k->id_tips }}" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg-max" role="document">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h5 class="modal-title text-light">Edit Tips</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_tips" value="{{ $k->id_tips }}">
                            <div class="row">
                                <input type="hidden" name="id_tips" value="{{ $k->id_tips }}">
                                <div class="col-md-12">
                                    <label for="">Tanggal</label>
                                    <input type="date" readonly class="form-control" name="tgl"
                                        value="{{ $k->tgl }}">
                                </div>

                                <div class="col-md-12">
                                    <label for="">Server</label>
                                    <input type="text" readonly class="form-control" name="admin"
                                        value="{{ $k->admin }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Nominal</label>
                                    <input type="number" name="nominal" class="form-control" value="{{ $k->nominal }}">
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-costume" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-costume">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
    {{-- ---------------- --}}
@endsection
