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

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Data Gaji</h5>
                                <a href="" data-toggle="modal" data-target="#summary"
                                    class="btn btn-info btn-sm float-right"><i class="fas fa-download"></i> Summary Gaji</a>
                                <!--<a href="" data-toggle="modal" data-target="#import"-->
                                <!--    class="btn mr-2 btn-info btn-sm float-right"><i class="fas fa-file-import"></i>-->
                                <!--    Import</a>-->
                                <!--<a href="{{ route('gajiExport') }}" class="btn mr-2 btn-info btn-sm float-right"><i-->
                                <!--        class="fas fa-file-export"></i>-->
                                <!--    Export</a>-->
                            </div>
                            @include('flash.flash')
                            <div class="card-body">
                                <table class="table  " id="table">

                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NAMA KARYAWAN</th>
                                            <th>POSISI</th>
                                            <th>TANGGAL MASUK</th>
                                            <th>RP M</th>
                                            <th>RP E</th>
                                            <th>RP SP</th>
                                            <th>BULANAN</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                            
                                        @endphp

                                        @foreach ($gaji as $k)
                                            @php
                                                $totalKerja = new DateTime($k->tgl_masuk);
                                                $today = new DateTime();
                                                $tKerja = $today->diff($totalKerja);
                                            @endphp
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $k->nama }}</td>
                                                <td>{{ $k->nm_posisi }}</td>
                                                <td>{{ $k->tgl_masuk }} ({{ $tKerja->y }} Tahun)</td>
                                                <td>{{ number_format($k->rp_m, 0) }}</td>
                                                <td>{{ number_format($k->rp_e, 0) }}</td>
                                                <td>{{ number_format($k->rp_sp, 0) }}</td>
                                                <td>{{ number_format($k->g_bulanan, 0) }}</td>
                                                <td style="white-space: nowrap;">
                                                    <a href="" data-toggle="modal"
                                                        data-target="#edit_data{{ $k->id_karyawan }}{{ $k->id_gaji }}"
                                                        id_menu="1" class="btn edit_menu btn-new"
                                                        style="background-color: #F7F7F7;"><i style="color: #B0BEC5;"><i
                                                                class="fas fa-edit"></i></a>
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
    <!-- /.content-wrapper -->
    <style>
        .modal-lg-max1 {
            max-width: 1100px;
        }

    </style>
    {{-- import --}}
    <form action="" method="post" enctype="multipart/form-data">
        <div class="modal fade" role="dialog" id="import" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Edit Gaji</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">Dari</label>
                                <input required class="form-control" type="file" name=" file">
                            </div>
                        </div>

                    </div>


                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- ------ --}}
    <div class="modal fade" role="dialog" id="summary" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-max1" role="document">
            <div class="modal-content ">
                <div class="modal-header btn-costume">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Edit Gaji</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="">Dari</label>
                            <input required class="form-control" type="date"" name=" dari" id="dari">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Sampai</label>
                            <input required class="form-control" type="date" name="sampai" id="sampai">
                        </div>
                        <div class="col-sm-1">
                            <label for="">Aksi</label>
                            <button id="submit" class="form-control btn btn-sm btn-info">View</button>
                        </div>
                    </div>

                    <div id="badan">

                    </div>

                </div>


                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    @foreach ($gaji as $s)
        <form action="{{ route('editGaji') }}" method="post">
            @method('patch')
            @csrf
            <div class="modal fade" id="edit_data{{ $s->id_karyawan }}{{ $s->id_gaji }}" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content ">
                        <div class="modal-header btn-costume">
                            <h5 class="modal-title text-light" id="exampleModalLabel">Edit Gaji</h5>
                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <input type="hidden" name="id_gaji" value="{{ $s->id_gaji }}">
                        <input type="hidden" name="id_karyawan" value="{{ $s->id_karyawan }}">
                        <div class="modal-body">
                            <p><b>Nama : {{ $s->nama }}</b></p>
                            <?php
                            $totalKerja = new DateTime($s->tgl_masuk);
                            $today = new DateTime();
                            $tKerja = $today->diff($totalKerja);
                            ?>
                            <p><b>Lama Bekerja : {{ $tKerja->y }} tahun</b></p>
                            <hr style="border: 1px solid black">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="">Rp M</label>
                                    <input class="form-control" type="text" value="{{ $s->rp_m }}" name="rp_m">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Rp E</label>
                                    <input class="form-control" type="text" value="{{ $s->rp_e }}" name="rp_e">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Rp SP</label>
                                    <input class="form-control" type="text" value="{{ $s->rp_sp }}" name="rp_sp">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Bulanan</label>
                                    <input class="form-control" type="text" value="{{ $s->g_bulanan }}"
                                        name="g_bulanan">
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

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <style>
        .modal-lg-max {
            max-width: 900px;
        }

    </style>



    {{-- ---------------- --}}
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#submit', function() {
                var dari = $('#dari').val()
                var sampai = $('#sampai').val()
                if (dari == '' || sampai == '') {
                    alert('Isi dulu Tanggalnya')
                } else {

                    $('#ketDari').text(dari)
                    $('#ketSampai').text(sampai)
                    $('#badan').load("{{ route('tabelGaji') }}?dari=" + dari + "&sampai=" + sampai,
                        "data",
                        function(response, status,
                            request) {
                            this; // dom element
                            $('#tableSum').DataTable({

                                "bSort": true,
                                // "scrollX": true,
                                "paging": true,
                                "stateSave": true,
                                "scrollCollapse": true
                            });
                        });
                }
                // alert(`dari : ${dari} sampai : ${sampai}`)
            })
        })
    </script>
@endsection
