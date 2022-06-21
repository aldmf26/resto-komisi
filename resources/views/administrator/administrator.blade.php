@include('template.head')
@include('template.header')
@include('template.navbar')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2 justify-content-center">
                <div class="col-sm-12">
                    <center>
                        <h4 style="color: #787878; font-weight: bold;">KARYAWAN</h4>
                    </center>
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
                            <h5>Database karyawan</h5>
                            <a href="#" data-toggle="modal" data-target="#importKaryawan"
                                class="ml-2 btn btn-info float-right"><i class="fas fa-file-import"></i> Import</a>
                            <a href="{{ route('karyawanExport') }}" class="ml-2 btn btn-info float-right"><i
                                    class="fas fa-file-excel"></i> Export</a>
                            <a href="" data-toggle="modal" data-target="#tambah" class="btn btn-info float-right"><i
                                    class="fas fa-plus"></i> Tambah karyawan</a>
                        </div>
                        {{-- modal import excel karyawan --}}
                        <!-- Modal -->
                        <div class="modal fade" id="importKaryawan" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Import Excel Karyawan</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('karyawanImport') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="file" required><br>
                                            <input type="submit" name="simpan" value="Simpan" id="tombol"
                                                class="btn btn-primary mt-3">
                                            <button type="button" class="btn btn-secondary  mt-3"
                                                data-dismiss="modal">Close</button>
                                    </div>
                                    </form>
                                    <div class="modal-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- akhir modal import excel karyawan --}}
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
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ $k->tgl_masuk }} (0 Tahun)</td>
                                            <td>{{ $k->nm_status }}</td>
                                            <td>{{ $k->nm_posisi }}</td>
                                            <td style="white-space: nowrap;">
                                                <a href="" data-toggle="modal"
                                                    data-target="#edit_data{{ $k->id_karyawan }}" id_menu="1"
                                                    class="btn edit_menu btn-new" style="background-color: #F7F7F7;"><i
                                                        style="color: #B0BEC5;"><i class="fas fa-edit"></i></a>
                                                <a onclick="return confirm('Apakah ingin dihapus ?')"
                                                    href="{{ route('deleteAdministrator', ['id_karyawan' => $k->id_karyawan]) }}"
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

</style>
<form action="{{ route('addAdministrator') }}" method="post" accept-charset="utf-8">
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
                                    <option value="{{ $p->id_posisi }}">{{ $p->nm_posisi }}</option>
                                @endforeach
                            </select>
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

{{-- modal untuk edit --}}
@foreach ($karyawan as $k)
    <form action="{{ route('editAdministrator') }}" method="post" accept-charset="utf-8">
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
                                        <option value="{{ $p->id_posisi }}"
                                            {{ $p->id_posisi == $k->id_posisi ? 'selected' : '' }}>
                                            {{ $p->nm_posisi }}</option>
                                    @endforeach
                                </select>
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
@include('template.footer')
