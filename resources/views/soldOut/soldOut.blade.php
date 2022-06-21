@extends('template.master')
@section('content')
    <div class="content-wrapper" style="min-height: 494px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 justify-content-center">
                    <div class="col-sm-12">
                        <center>
                            <h4 style="color: rgb(120, 120, 120); font-weight: bold; --darkreader-inline-color:#837e75;"
                                data-darkreader-inline-color="">Sold Out</h4>
                        </center>

                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6">
                        <!-- <a class="btn btn-info float-right" data-toggle="modal" data-target="#view"><i class="fas fa-eye"></i> View</a> -->
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('addSoldOut') }}" method="post">
                                    @csrf
                                    <label for="">Menu</label>
                                    <div class="form-group" data-select2-id="93">
                                        <select name="id_menu[]" class="select2 select2-hidden-accessible" multiple=""
                                            data-placeholder="- Menu -" style="width: 100%;" data-select2-id="7"
                                            tabindex="-1" aria-hidden="true">
                                            @foreach ($menu as $d)
                                                <option value="{{ $d->id_menu }}">{{ $d->nm_menu }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary float-right mt-2">Save</button>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        @include('flash.flash')
                                        <div class="col-sm-12">
                                            <table class="table dataTable no-footer" id="table" role="grid"
                                                aria-describedby="table_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Menu</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($sold_out as $b)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $b->tgl }}</td>
                                                            <td>{{ $b->nm_menu }}</td>
                                                            <td>
                                                                <a href="{{ route('hapusSoldOut', ['id' => $b->id_sold_out]) }}"
                                                                    onclick="return confirm('Apakah yakin ?')"
                                                                    class="btn btn-danger"><i
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

                    <form action="" method="get">
                        <div class="modal fade" id="view">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h4 class="modal-title">View</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('.select2').select2()
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            var count_soldout = 1;

        })
    </script>
@endsection
