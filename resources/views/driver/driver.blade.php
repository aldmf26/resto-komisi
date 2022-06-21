@extends('template.master')
@section('content')
    <div class="content-wrapper" style="min-height: 511px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 ">
                    <div class="col-lg-6">
                    </div>

                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-left">Data Driver</h5>
                                <a href="#" data-toggle="modal" data-target="#print"
                                    class="btn btn-info btn-sm float-right mr-2"><i class="fas fa-print"></i> Print
                                    kasbon</a>
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
                                                        <th>No Order</th>
                                                        <th>Nama Driver</th>
                                                        <th>Nominal</th>
                                                        <th>Tanggal</th>
                                                        <th>Admin</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($driver as $d)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $d->no_order }}</td>
                                                            <td>{{ $d->nm_driver }}</td>
                                                            <td>{{ $d->nominal }}</td>
                                                            <td>{{ $d->tgl }}</td>
                                                            <td>{{ $d->admin }}</td>
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
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    {{-- print --}}
    <form action="{{ route('printDriver') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="print" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Print Driver</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Dari</label>
                                    <input class="form-control" type="date" name="dari">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Sampai</label>
                                    <input class="form-control" type="date" name="sampai">
                                </div>
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
    {{-- ------------------------------------ --}}
@endsection
