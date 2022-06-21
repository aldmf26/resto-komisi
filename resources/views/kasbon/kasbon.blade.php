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
                                <h5 class="float-left">Data Kasbon</h5>
                                <a href="" data-toggle="modal" data-target="#tambah"
                                    class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Tambah kasbon</a>
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
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>Nominal</th>
                                                        <th>Tanggal</th>
                                                        <th>Admin</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($kasbon as $k)
                                                        <tr class="odd">
                                                            <td class="sorting_1">{{ $no++ }}</td>
                                                            <td>{{ ucwords(Str::lower($k->nm_karyawan)) }}</td>
                                                            <td>{{ number_format($k->nominal, 0) }}</td>
                                                            <td>{{ $k->tgl }}</td>
                                                            <td>{{ ucwords(Str::lower($k->admin)) }}</td>
                                                            <td>
                                                                <a href="" data-target="#edit_data{{ $k->id_kasbon }}"
                                                                    data-toggle="modal" class="btn btn-sm btn-warning"><i
                                                                        class="fas fa-edit"></i></a>
                                                                <a href="{{ route('deleteKasbon', ['id_kasbon' => $k->id_kasbon]) }}"
                                                                    onclick="return confirm('Apakah anda yakin?')"
                                                                    class="btn btn-sm btn-danger"><i
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
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    {{-- print --}}
    <form action="{{ route('printKasbon') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="print" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Print kasbon</h5>
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
    <form action="{{ route('addKasbon') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah kasbon</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <label for="">tanggal</label>
                                <input type="date" name="tgl" class="form-control">
                            </div>



                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <label for="">Nama</label>
                                <select name="nama[]" id="" class="form-control">
                                    <option value="">-Pilih Karyawan-</option>
                                    @foreach ($karyawan as $k)
                                        <option value="{{ $k->nama }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-5">
                                <label for="">Nominal</label> <br>
                                <input type="number" class="form-control" name="nominal[]">
                            </div>
                            <div class="col-lg-2">
                                <label for="">Aksi</label> <br>
                                <a class="btn btn-sm btn-info tbh"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div id="kasbon">

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
    @foreach ($kasbon as $k)
        <form action="{{ route('editKasbon') }}" method="post" accept-charset="utf-8">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit_data{{ $k->id_kasbon }}" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg-max" role="document">
                    <div class="modal-content ">
                        <div class="modal-body">
                            <input type="hidden" name="id_kasbon" value="2">
                            <input type="hidden" name="id_kasbon" value="{{ $k->id_kasbon }}">
                            <div class="row">
                                <div class="col-lg-5">
                                    <label for="">Tanggal</label>
                                    <input type="date" class="form-control" name="tgl" value="{{ $k->tgl }}">
                                </div>

                                <div class="col-lg-4">
                                    <label for="">Karyawan</label>
                                    <select name="nama" id="" class="form-control">
                                        <option value="{{ $k->nm_karyawan }}">{{ $k->nm_karyawan }}</option>
                                        @foreach ($karyawan as $s)
                                            <option value="{{ $s->nama }}"
                                                {{ $s->nama == $k->nm_karyawan ? 'selected' : '' }}>
                                                {{ $s->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Nominal</label>
                                    <input type="number" name="nominal" class="form-control" value="{{ $k->nominal }}">
                                </div>
                                <input type="hidden" name="admin" value="{{ $k->admin }}">
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
    {{-- ---------------- --}}
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var count = 1;
            $('.tbh').click(function() {
                count = count + 1;
                // var no_nota_atk = $("#no_nota_atk").val();
                var html_code = "<div class='row' id='row" + count + "'>";

                html_code +=
                    ' <div class="col-5 mt-2"><select name="nama[]" id="" class="form-control select"> <option value="">-Piih Karyawan-</option><option value="MAS_ARI">MAS_ARI</option><option value="WAWAN">WAWAN</option><option value="ANDI">ANDI</option><option value="INOV">INOV</option><option value="GUNAWAN">GUNAWAN</option><option value="FAJAR">FAJAR</option><option value="FAUZAN">FAUZAN</option><option value="YADI">YADI</option><option value="UGI">UGI</option><option value="SUFIAN">SUFIAN</option><option value="RENALDI">RENALDI</option><option value="AHMAD">AHMAD</option><option value="LANA">LANA</option><option value="MADI">MADI</option><option value="FERI">FERI</option><option value="BUDIMAN">BUDIMAN</option><option value="AGUS">AGUS</option><option value="HENDRI">HENDRI</option><option value="HERLINA">HERLINA</option><option value="RIDWAN">RIDWAN</option><option value="BUDI_RAHMAT">BUDI_RAHMAT</option><option value="SERLI">SERLI</option><option value="TRAINING">TRAINING</option><option value="DEA">DEA</option><option value="AISYAH">AISYAH</option><option value="ALBANJARI">ALBANJARI</option><option value="DAYAT">DAYAT</option><option value="FAZRI">FAZRI</option><option value="PUTRI">PUTRI</option><option value="ANGEL">ANGEL</option><option value="KOMANG">KOMANG</option><option value="NETY">NETY</option><option value="AZIS">AZIS</option><option value="DEWI">DEWI</option><option value="JUNAIDI">JUNAIDI</option><option value="RIA">RIA</option><option value="Eren">Eren</option><option value="wahyudi">wahyudi</option> </select></div>';

                html_code +=
                    ' <div class="col-5 mt-2"><input type="number" name="nominal[]" class="form-control"></div>';

                html_code +=
                    "<div class='col-lg-2 mt-2'><button type='button' name='remove' data-row='row" + count +
                    "' class='btn btn-danger btn-xs remove'><i class='fas fa-minus'></i></button></div>";

                html_code += "</div>";

                $('#kasbon').append(html_code);
                $('.select').select2()
            });

            $(document).on('click', '.remove', function() {
                var delete_row = $(this).data("row");
                $('#' + delete_row).remove();
            });

        });
    </script>
@endsection
