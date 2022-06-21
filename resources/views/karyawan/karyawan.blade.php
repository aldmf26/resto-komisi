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
                                <h5>Data karyawan</h5>
                                <?php if(Auth::user()->username == 'herry' || Auth::user()->username == 'linda'){ ?>
                                <a href="#" data-target="#import" data-toggle="modal" class="btn btn-primary float-right ml-2"><i
                                        class="fas fa-file-import"></i> Import</a>
                                <?php }else{ ?>    
                                <?php } ?>
                                <a href="" data-toggle="modal" data-target="#tambah" class="btn btn-info float-right"><i
                                        class="fas fa-plus"></i> Tambah karyawan</a>
                            </div>
                            @include('flash.flash')
                            <div class="card-body">
                                <table class="table  " id="table">

                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NAMA KARYAWAN</th>
                                            <th>TANGGAL MASUK</th>
                                            <th>STATUS</th>
                                            <th>POSISI</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($karyawan as $k)
                                            @php
                                                $totalKerja = new DateTime($k->tgl_masuk);
                                                $today = new DateTime();
                                                $tKerja = $today->diff($totalKerja);
                                            @endphp
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $k->nama }}</td>
                                                <td>{{ $k->tgl_masuk }} ({{ $tKerja->y }} Tahun)</td>
                                                <td>{{ $k->nm_status }}</td>
                                                <td>{{ $k->nm_posisi }}</td>
                                                <td style="white-space: nowrap;">
                                                    <a href="" data-toggle="modal"
                                                        data-target="#edit_data{{ $k->id_karyawan }}" id_menu="1"
                                                        class="btn edit_menu btn-new" style="background-color: #F7F7F7;"><i
                                                            style="color: #B0BEC5;"><i class="fas fa-edit"></i></a>
                                                    <a onclick="return confirm('Apakah ingin dihapus ?')"
                                                        href="{{ route('deleteKaryawan', ['id_karyawan' => $k->id_karyawan]) }}"
                                                        class="btn  btn-new" style="background-color: #ff0000;">
                                                        <i style="color: #B0BEC5;"><i class="fas fa-trash-alt"></i></a>
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

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <style>
        .modal-lg-max {
            max-width: 900px;
        }
        .modal-mds {
            max-width: 700px;
        }

    </style>
    {{-- import --}}
    <form action="{{ route('gajiImport') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal fade" id="import" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-mds" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-dark" id="exampleModalLabel">Import Gaji</h5>
                        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <table>
                                <tr>
                                <td width="100" class="pl-2">
                                    <img width="80px" src="{{ asset('assets') }}/img/1.png" alt="">
                                </td>
                                <td>
                                    <span style="font-size: 20px;"><b> Download Excel template</b></span><br>
                                    File ini memiliki kolom header dan isi yang sesuai dengan data karyawan
                                </td>
                                <td>
                                    <a href="{{ route('gajiExportTemplate') }}" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> DOWNLOAD TEMPLATE</a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td width="100" class="pl-2">
                                    <img width="80px" src="{{ asset('assets') }}/img/2.png" alt="">
                                </td>
                                <td>
                                    <span style="font-size: 20px;"><b> Upload Excel template</b></span><br>
                                    Setelah mengubah, silahkan upload file.
                                </td>
                                <td>
                                    <input type="file" name="file" class="form-control">
                                </td>
                            </tr>
                            </table>
                            
                        </div>
                        <div class="row">
                            <div class="col-12">
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Edit / Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- -------------------------------- --}}

    <form action="{{ route('addKaryawan') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah karyawan</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="">Tgl Masuk</label>
                                <input type="date" name="tgl_masuk" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label for="">Nama</label>
                                <input type="text" name="nama" class="form-control">
                            </div>
                            <div class="col-lg-3">
                                <label for="">Status</label>
                                <select name="status" id="" class="form-control">
                                    <option value="">- Pilih Status - </option>
                                    @foreach ($status as $s)
                                        <option value="{{ $s->id_status }}">{{ $s->nm_status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Posisi</label>
                                <select name="posisi" id="" class="form-control">
                                    <option value="">- Pilih Posisi - </option>
                                    @foreach ($posisi as $p)
                                        <?php if($p->id_posisi == 1){ ?>
                                        <?php continue; ?>
                                        <?php } ?>
                                        <option value="{{ $p->id_posisi }}">{{ $p->nm_posisi }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-3">
                                    <label for="">Rp M</label>
                                    <input class="form-control" required type="text" value="" name="rp_m">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Rp E</label>
                                    <input class="form-control" required type="text" value="" name="rp_e">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Rp SP</label>
                                    <input class="form-control" required type="text" value="" name="rp_sp">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Bulanan</label>
                                    <input class="form-control" required type="text" value=""
                                        name="g_bulanan">
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

    {{-- modal untuk edit --}}
    @foreach ($karyawan as $k)
        <form action="{{ route('editKaryawan') }}" method="post" accept-charset="utf-8">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit_data{{ $k->id_karyawan }}" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg-max" role="document">
                    <div class="modal-content ">
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="id_karyawan" value="{{ $k->id_karyawan }}">
                                <div class="col-lg-3">
                                    <label for="">Tgl Masuk</label>
                                    <input type="date" value="{{ $k->tgl_masuk }}" name="tgl_masuk"
                                        class="form-control">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Nama</label>
                                    <input type="text" name="nama" value="{{ $k->nama }}" class="form-control">
                                </div>

                                <div class="col-lg-3">
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="">- Pilih Status - </option>
                                        @foreach ($status as $s)
                                            <option value="{{ $s->id_status }}"
                                                {{ $s->id_status == $k->id_status ? 'selected' : '' }}>
                                                {{ $s->nm_status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Posisi</label>
                                    <select name="posisi" id="" class="form-control">
                                        <option value="">- Pilih Posisi - </option>
                                        @foreach ($posisi as $p)
                                            <?php if($p->id_posisi == 1){ ?>
                                            <?php continue; ?>
                                            <?php } ?>
                                            <option value="{{ $p->id_posisi }}"
                                                {{ $p->id_posisi == $k->id_posisi ? 'selected' : '' }}>
                                                {{ $p->nm_posisi }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <?php if(Auth::user()->username == 'herry' || Auth::user()->username == 'linda'){ ?>
                            <hr style="border: 1px solid black">
                            <div class="row">
                                @php
                                    $gaji = DB::select("SELECT a.*, b.*, c.id_gaji, c.rp_e, c.rp_m, c.rp_sp, c.g_bulanan FROM tb_karyawan as a LEFT JOIN tb_posisi as b ON a.id_posisi =  b.id_posisi LEFT JOIN tb_gaji as c ON a.id_karyawan = c.id_karyawan WHERE a.id_karyawan = $k->id_karyawan ORDER BY a.tgl_masuk DESC");
                                @endphp
                                @foreach ($gaji as $s)                          
                                <input type="hidden" name="id_gaji" value="{{ $s->id_gaji }}">
                                
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
                                @endforeach
                            </div>
                            <?php }else{ ?>
                            <?php } ?>
                            
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
@section('script')
@endsection
