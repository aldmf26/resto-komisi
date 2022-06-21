@extends('template.master')
@section('content')
    <div class="content-wrapper" style="min-height: 494px;">
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-left">Data Denda</h5>
                                <a href="" data-toggle="modal" data-target="#tambah"
                                    class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Tambah Data</a>
                                <a href="#" data-toggle="modal" data-target="#print2" class="btn btn-info btn-sm float-right mr-2"><i
                                        class="fas fa-print"></i> Export</a>
                                <!--<a href="#" data-toggle="modal" data-target="#print" class="btn btn-info btn-sm float-right mr-2"><i-->
                                <!--        class="fas fa-print"></i>Print</a>-->
                            </div>
                            <div class="card-body">
                                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table dataTable no-footer" id="table" role="grid"
                                                aria-describedby="table_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama</th>
                                                        <th>Alasan</th>
                                                        <th>Nominal</th>
                                                        <th>Lokasi</th>
                                                        <th>Admin</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                   @foreach ($denda as $d)
                                                        @php
                                                            if ($d->id_lokasi == 1) {
                                                                $lokasi = 'TAKEMORI';
                                                            } else {
                                                                $lokasi = 'SOONDOBU';
                                                            }
                                                        @endphp
                                                        <tr class="odd">
                                                            <td>{{ $no++ }}</td>
                                                            <td width="100">{{ $d->tgl }}</td>
                                                            <td>{{ ucwords(Str::lower($d->nama)) }}</td>
                                                            <td width="300">{{ $d->alasan }}</td>
                                                            <td width="100">Rp.
                                                                {{ number_format($d->nominal, 0, '.', '.') }}</td>
                                                            <td>{{ $lokasi }}</td>

                                                            <td>{{ ucwords(Str::lower($d->admin)) }}</td>
                                                            <td width="100">
                                                                <a data-target="#edit_data{{ $d->id_denda }}"
                                                                    data-toggle="modal" class="btn btn-info btn-sm"><i
                                                                        class="fas fa-edit"></i></a>
                                                                <a href="{{ route('deleteDenda', ['id_denda' => $d->id_denda]) }}"
                                                                    onclick="return confirm('Apakah anda yakin?')"
                                                                    class="btn btn-danger btn-sm"><i
                                                                        class="fas fa-trash"></i></a>
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
    {{-- print --}}
    <form action="{{ route('printDenda') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="print" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Print Denda</h5>
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
    {{-- print 2 --}}
    <form action="{{ route('printDendaPerorang') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="print2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Print Denda Perorang</h5>
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
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="btn btn-default btn-block" for="btnCheck-1">ALL</label>
                            </div>
                            <div class="col-lg-4">
                                <input type="checkbox" name="id_karyawan[]" class="selectAll btn-check" value="0" id="btnCheck-1" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            @php
                                $no=1;
                            @endphp
                            @foreach ($karyawan as $k)
                            <div class="col-3">
                                {{-- <label for="">Nama</label>
                                <select name="nama" id="jenisExport" class="form-control select2bs4">
                                    <option value="0">ALL</option>
                                        @foreach ($karyawan as $k)
                                            <option value="{{ $k->nama }}">{{ $k->nama }}</option>
                                        @endforeach
                                </select> --}}
                                <label class="btn btn-default" for="btnCheck{{$no}}">{{ $k->nama }}</label>
                                
                            </div>
                            <div class="col-lg-1">
                                <input type="checkbox" name="id_karyawan[]" class="btn-check dicek" value="{{ $k->nama }}" id="btnCheck{{$no}}" autocomplete="off">

                            </div>
                            @php
                                $no++;
                            @endphp
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btnExport">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- ------------------------------------ --}}
    
    <form action="{{ route('addDenda') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah Denda</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="list_kategori">Tanggal</label>
                                    <input class="form-control" type="date" name="tgl">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="list_kategori">Nama</label>
                                    <select class="form-control" name="nama" id="">
                                        <option>-- Pilih Nama --</option>
                                        @foreach ($karyawan as $k)
                                            <option value="{{ $k->nama }}">{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="list_kategori">Alasan</label>
                                    <input class="form-control" type="text" name="alasan">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="list_kategori">Nominal</label>
                                    <input class="form-control" type="number" name="nominal">
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
    {{-- modal untuk edit --}}
    @foreach ($denda as $k)
        <form action="{{ route('editDenda') }}" method="post" accept-charset="utf-8">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit_data{{ $k->id_denda }}" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg-max" role="document">
                    <div class="modal-content ">
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="id_denda" value="{{ $k->id_denda }}">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="list_kategori">Tanggal</label>
                                        <input class="form-control" type="date" name="tgl" value="{{ $k->tgl }}">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="list_kategori">Nama</label>
                                        <select class="form-control" name="nama" id="">
                                            <option value="{{ $k->nama }}">{{ $k->nama }}</option>
                                            @foreach ($karyawan as $s)
                                                <option value="{{ $s->nama }}"
                                                    {{ $s->nama == $k->nm_karyawan ? 'selected' : '' }}>
                                                    {{ $s->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="list_kategori">Alasan</label>
                                        <input class="form-control" type="text" name="alasan"
                                            value="{{ $k->alasan }}">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="list_kategori">Nominal</label>
                                        <input class="form-control" type="number" name="nominal"
                                            value="{{ $k->nominal }}">
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-costume" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-costume">Edit / Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
@section('script')
    <script>
                $('.select2bs4').select2({
                            theme: 'bootstrap4'
                        });
    </script>
    <script>
        $(document).ready(function () {
            
            $(".selectAll").click(function(){
              
                if($(this).is(':checked')) {
                    $(".dicek").attr("disabled", true);
                    $(".dicek").attr("checked", true);
                } else {
                    $(".dicek").removeAttr("disabled", true);
                    $(".dicek").removeAttr("checked", true);
                }
                
            });
        });
    </script>
@endsection