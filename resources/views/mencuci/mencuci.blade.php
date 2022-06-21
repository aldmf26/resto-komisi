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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-left">Data Mencuci</h5>
                                <a href="" data-toggle="modal" data-target="#tambah"
                                    class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Tambah Data</a>
                                    <a href="" data-toggle="modal" data-target="#view"
                                class="btn btn-info btn-sm float-right mr-2"><i class="fas fa-eye"></i> View</a>
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
                                                        <th>Nama</th>
                                                        <th>Ket</th>
                                                        <th>Ket2</th>
                                                        <th>Jam Mulai</th>
                                                        <th>Jam Selesai</th>
                                                        <th>Tanggal</th>
                                                        <th>Admin</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($mencuci as $m)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ ucwords(Str::lower($m->nm_karyawan)) }}</td>
                                                            <td>{{ $m->ket }}</td>
                                                            <td>{{ $m->ket2 }}</td>
                                                            <td>{{ $m->j_awal }}</td>
                                                            <td>{{ $m->j_akhir }}</td>
                                                            <td>{{ date('d-m-Y',strtotime($m->tgl)) }}</td>
                                                            <td>{{ ucwords(Str::lower($m->admin)) }}</td>
                                                            <td style="white-space:nowrap;">
                                                                <a href="#edit{{ $m->id_mencuci }}" data-toggle="modal"
                                                                    class="btn btn-warning btn-sm"><i
                                                                        class="fas fa-edit"></i></a>
                                                                <a href="{{ route('deleteMencuci', ['id_mencuci' => $m->id_mencuci]) }}"
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
    <style>
        .modal-lg-max {
            max-width: 1000px;
        }

    </style>
    
    <form action="" method="get">
    <div class="modal fade" id="view" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content ">
                <div class="modal-header btn-costume">
                    <h5 class="modal-title text-light" id="exampleModalLabel">View Menu</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Dari</label>
                            <input type="date" class="form-control" name="tgl1">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Sampai</label>
                            <input type="date" class="form-control" name="tgl2">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </div>
        </div>
    </div>
</form>
    <form action="{{ route('addMencuci') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah mencuci</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="">Nama</label>
                                <select required name="nama[]" id="" class="form-control">
                                    <option value="">-Pilih Karyawan-</option>
                                    @foreach ($karyawan as $k)
                                        <option value="{{ $k->nama }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="">Ket</label>
                                <select required name="ket[]" id="" class="form-control">
                                    <option value="">-Pilih keterangan-</option>
                                    @foreach ($ket as $k)
                                        <option value="{{ $k->id_ket }}">{{ $k->ket }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-lg-2">
                                <label for="">Keterangan2</label>
                                <input required type="text" name="ket2[]"  class="form-control">
                            </div>
                            <div class="col-lg-2">
                                <label for="">tanggal</label>
                                <input required type="date" name="tgl[]" value="{{date('Y-m-d')}}" class="form-control">
                            </div>
                            <div class="col-lg-2">
                                <label for="">Jam Mulai</label>
                                <input required type="time" name="j_awal[]" class="form-control">
                            </div>
                            <div class="col-lg-2">
                                <label for="">Jam Akhir</label>
                                <input required type="time" name="j_akhir[]" class="form-control">
                            </div>
                            <div class="col-lg-1">
                                <label for="">Aksi</label> <br>
                                <a class="btn btn-sm btn-info tbh"><i class="fas fa-plus"></i></a>
                            </div>


                        </div>
                        <div id="mencuci">

                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- modal edit --}}
    @foreach ($mencuci as $m)
        <form action="{{ route('editMencuci') }}" method="post" accept-charset="utf-8">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit{{ $m->id_mencuci }}" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg-max" role="document">
                    <div class="modal-content ">
                        <div class="modal-header btn-costume">
                            <h5 class="modal-title text-light" id="exampleModalLabel">Edit mencuci</h5>
                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3">]
                                    <input type="hidden" value="{{ $m->id_mencuci }}" name="id_mencuci">
                                    <label for="">Nama</label>
                                    <select name="nama" id="" class="form-control">
                                        <option value="{{ $m->nm_karyawan }}">{{ $m->nm_karyawan }}</option>
                                        @foreach ($karyawan as $k)
                                            <option {{ $m->nm_karyawan == $k->nama ? 'selected' : '' }}
                                                value="{{ $k->nama }}">{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Ket</label>
                                    <select name="ket" id="" class="form-control">
                                        <option value="{{ $m->id_ket }}">{{ $m->ket }}</option>
                                        @foreach ($ket as $k)
                                            <option {{ $m->ket == $k->ket ? 'selected' : '' }}
                                                value="{{ $k->id_ket }}">{{ $k->ket }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Keterangan2</label>
                                    <input class="form-control" placeholder="keterangan 2" value="{{ $m->ket2 }}" name="ket2" type="text">
                                </div>
                                <div class="col-lg-2">
                                    <label for="">tanggal</label>
                                    <input type="date" name="tgl" value="{{ $m->tgl }}" class="form-control">
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Jam Mulai</label>
                                    <input type="time" name="j_awal" value="{{ $m->j_awal }}" class="form-control">
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Jam Akhir</label>
                                    <input type="time" name="j_akhir" value="{{ $m->j_akhir }}" class="form-control">
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
    @endforeach
    {{-- ---------- --}}
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            
            var count = 1;
            $(document).on('click', '.tbh', function() {
            //    alert(1)
                count = count + 1;
                // var no_nota_atk = $("#no_nota_atk").val();
                var html_code = "<div class='row' id='row" + count + "'>";

                html_code +=' <div class="col-3 mt-2"><select name="nama[]" id="" class="form-control select"> <option value="">-Piih Karyawan-</option>@foreach ($karyawan as $k)<option value="{{ $k->nama }}">{{ $k->nama }}</option>@endforeach</select></div > ';
                html_code +=' <div class="col-2 mt-2"><select name="ket[]" id="" class="form-control select"required> <option value="">-Piih Keterangan-</option><option value="1">CLEAR-UP</option><option value="2">CUCI</option><option value="3">MASAK</option><option value="4">PREPARE</option></select></div>';

                html_code +=' <div class="col-lg-2"><input class="form-control" placeholder="keterangan 2" name="ket2[]" type="text"></div>';
                html_code +=' <div class="col-2 mt-2"><input type="date" name="tgl[]" value="{{date('Y-m-d')}}" class="form-control"></div>';
                html_code +=' <div class="col-2 mt-2"><input type="time" name="j_awal[]" class="form-control"></div>';
                html_code +=' <div class="col-2 mt-2"><input type="time" name="j_akhir[]" class="form-control"></div>';

                html_code +="<div class='col-lg-1 mt-2'><button type='button' name='remove' data-row='row" + count +"' class='btn btn-danger btn-xs remove'><i class='fas fa-minus'></i></button></div>";

                html_code += "</div>";

                $('#mencuci').append(html_code);
                $('.select').select2()
            });

            $(document).on('click', '.remove', function() {
                var delete_row = $(this).data("row");
                $('#' + delete_row).remove();
            });

        });
    </script>
@endsection
