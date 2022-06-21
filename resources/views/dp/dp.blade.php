@extends('template.master')
@section('content')
    <div class="content-wrapper" style="min-height: 494px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 ">
                    <div class="col-lg-10">


                    </div>

                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-left">Dp</h5>
                                <a href="" data-toggle="modal" data-target="#tambah"
                                    class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Tambah Dp</a>
                            </div>
                            <div class="card-body">
                                <div id="table3_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="table3" class="table dataTable no-footer" width="100%" role="grid"
                                                aria-describedby="table3_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th>KODE</th>
                                                        <th>JUMLAH</th>
                                                        <th>CUSTOMER</th>
                                                        <th>SERVER</th>
                                                        <th>KETERANGAN</th>
                                                        <th>TANGGAL</th>
                                                        <th>METODE</th>
                                                        <th>STATUS</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($dp as $d)
                                                        @php
                                                            if ($d->status == 1) {
                                                                $status = 'Aktif';
                                                            } else {
                                                                $status = 'Terpakai';
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $d->kd_dp }}</td>
                                                            <td style="white-space: nowrap;">Rp.
                                                                {{ number_format($d->jumlah, 0) }}</td>
                                                            <td>{{ ucwords(Str::lower($d->nm_customer)) }}</td>
                                                            <td>{{ ucwords(Str::lower($d->server)) }}</td>
                                                            <td>{{ $d->ket }}</td>
                                                            <td>{{ $d->tgl }}</td>
                                                            <td>{{ ucwords(Str::lower($d->metode)) }}</td>
                                                            <td>
                                                                {{ $status }}
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
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <form action="{{ route('addDp') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah Dp</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input type="date" class="form-control" name="tgl" required="">
                                </div>
                            </div>


                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label for="">Jumlah</label>
                                    <input type="number" class="form-control" name="jumlah" required="">
                                </div>
                            </div>

                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label for="">Nama Customer</label>
                                    <input type="text" class="form-control" name="nm_customer" required="">
                                </div>
                            </div>

                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <input type="text" class="form-control" name="ket" required="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-froup">
                                    <label for="">Metode</label>
                                    <select name="metode" id="" class="form-control">
                                        <option value="CASH">CASH</option>
                                        <option value="BCA">BCA</option>
                                        <option value="MANDIRI">MANDIRI</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-froup">
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="0">ON</option>
                                        <option value="1">OFF</option>
                                    </select>
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
@endsection
