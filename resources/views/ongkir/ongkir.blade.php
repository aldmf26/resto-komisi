@extends('template.master')
@section('content')
    <div class="content-wrapper">
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
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-left">Free Ongkir</h5>

                            </div>
                            <div class="card-body">
                                <table class="table  " id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Ongkir</th>
                                            <th>Rupiah</th>
                                            <th>Rp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                            $total = 0;
                                        @endphp
                                        @foreach ($ongkir as $o)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $o->nama_ongkir }}</td>
                                                <td>{{ number_format($o->rupiah, 0) }}</td>
                                                @php
                                                    $total += $o->rupiah;
                                                @endphp
                                                <td><a href="#" data-toggle="modal" data-target="#edit{{ $o->id_ongkir }}"
                                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">TOTAL</th>
                                            <th>{{ number_format($total, 0) }}</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-left">Batas Pembelian</h5>

                            </div>
                            <div class="card-body">
                                <table class="table  " id="table2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Batas Pembelian</th>
                                            <th>Rupiah</th>
                                            <th>Rp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($batas_ongkir as $b)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>Batas Pembelian</td>
                                                <td>{{ number_format($b->rupiah, 0) }}</td>
                                                <td><a href="#" data-toggle="modal"
                                                        data-target="#editBatas{{ $b->id_batas_ongkir }}"
                                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
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
    @foreach ($ongkir as $o)
        <form action="{{ route('editOngkir') }}" method="post">
            @csrf
            <div class="modal fade" id="edit{{ $o->id_ongkir }}" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content ">
                        <div class="modal-header btn-costume">
                            <h5 class="modal-title text-light" id="exampleModalLabel">Edit Ongkir</h5>
                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="">Rupiah</label>
                            <input type="text" class="form-control" name="rupiah" value="{{ $o->rupiah }}">
                            <input type="hidden" class="form-control" name="id_ongkir" value="{{ $o->id_ongkir }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-costume">Edit/Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
    @foreach ($batas_ongkir as $b)
        <form action="{{ route('editBatasOngkir') }}" method="post">
            @csrf
            <div class="modal fade" id="editBatas{{ $b->id_batas_ongkir }}" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content ">
                        <div class="modal-header btn-costume">
                            <h5 class="modal-title text-light" id="exampleModalLabel">Edit Batas Ongkir</h5>
                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="">Rupiah</label>
                            <input type="text" class="form-control" name="rupiah" value="{{ $b->rupiah }}">
                            <input type="hidden" class="form-control" name="id_batas_ongkir"
                                value="{{ $b->id_batas_ongkir }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-costume">Edit/Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach

    <!-- /.content-wrapper -->
@endsection
