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
                                <h5>Database Discount</h5>
                            </div>
                            <div class="card-body">
                                <table class="table  " id="table">

                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>KETERANGAN</th>
                                            <th>JENIS</th>
                                            <th>DISCOUNT (RP / %)</th>
                                            <th>DARI</th>
                                            <th>SAMPAI</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <form action="{{ route('addDiscount') }}" method="post">
                                                @csrf
                                                <td>
                                                    <input required type="text" class="form-control" name="ket"
                                                        placeholder="Keterangan" required="">
                                                </td>
                                                <td>
                                                    <select class="form-control mr-2" name="jenis" id="">
                                                        <option value="">- Jenis Diskon -</option>
                                                        <option value="Rp">Rp</option>
                                                        <option value="Persen">Persen</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="disc"
                                                        placeholder="jumlah Discount" required="">
                                                    <p class="text-warning text-sm">Jika jenis rp (cth: 70000)
                                                        Jika jenis
                                                        persen
                                                        (cth: 10)</p>
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="dari" required="">
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="expired" required="">
                                                </td>
                                                <td style="white-space: nowrap;">
                                                    <input value="Simpan" type="submit" class="btn btn-primary">
                                                </td>
                                            </form>
                                        </tr>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($disc as $d)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $d->ket }}</td>
                                                <td>{{ $d->jenis }}</td>
                                                <td>
                                                    {{ $d->jenis == 'Rp' ? 'Rp. ' . number_format($d->disc) : number_format($d->disc) . '%' }}
                                                </td>
                                                <td>{{ $d->dari }}</td>
                                                <td>{{ $d->expired }}</td>

                                                <td>
                                                    <a href="#edit{{ $d->id_discount }}" data-toggle="modal"
                                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a onclick="return confirm('Apakah yakin ingin menghapus ?')"
                                                        href="{{ route('deleteDiscount', ['id_discount' => $d->id_discount]) }}"
                                                        class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5>Database Voucher</h5>
                                    </div>
                                    <div class="col-lg-6">
                                        <a class="btn btn-secondary btn-md float-right" href="{{ route('exportVoucher', ['id_lokasi' => Session::get('id_lokasi')]) }}" target="_blank"><i class="fa fa-file-excel"></i> Export</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table  " id="tabelAbsen">

                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>KODE</th>
                                            <th>JUMLAH</th>
                                            <th>KETERANGAN</th>
                                            <th>EXPIRED</th>
                                            <th>STATUS</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <form action="{{ route('addVoucher') }}" method="post">
                                                @csrf
                                                <td>
                                                    <input type="number" class="form-control" name="jumlah"
                                                        placeholder="Jumlah Voucher" required="">
                                                </td>
                                                <td><input type="text" class="form-control" name="ket"
                                                        placeholder="keterangan" required=""></td>
                                                <td>
                                                    <input type="date" class="form-control" name="expired" required="">
                                                </td>
                                                <td>
                                                    <select name="status" id="" class="form-control" required="">
                                                        <option value="">- Pilih -</option>
                                                        <option value="1">Aktif</option>
                                                        <option value="0">Non-Aktif</option>
                                                    </select>
                                                </td>
                                                <td style="white-space: nowrap;">
                                                    <input type="submit" value="Simpan" class="btn btn-primary">
                                                </td>
                                            </form>
                                        </tr>
                                        @foreach ($voucher as $v)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $v->kode }}</td>
                                                <td>{{ $v->jumlah }}</td>
                                                <td>{{ $v->ket }}</td>
                                                <td>{{ $v->expired }}</td>
                                                <?php if($v->terpakai == 'belum'){ ?>
                                                <td>
                                                    <?php if($v->status == '1'){ ?>
                                                    <input id="<?= $v->id_voucher ?>"
                                                        class="un-voucher voin<?= $v->id_voucher ?>" type="checkbox"
                                                        data-toggle="switchbutton" checked>
                                                    <div id="console-event<?= $v->id_voucher ?>"></div>
                                                    <?php }else { ?>
                                                    <input id="<?= $v->id_voucher ?>" terpakai="<?= $v->terpakai ?>"
                                                        class="in-voucher voun<?= $v->id_voucher ?>" type="checkbox"
                                                        data-toggle="switchbutton">
                                                    <div id="console-event<?= $v->id_voucher ?>"></div>
                                                    <?php } ?>
                                                </td>
      
                                                <td>
                                                    <a href="#edit{{ $v->id_voucher }}" data-toggle="modal"
                                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('deleteVoucher', ['id_voucher' => $v->id_voucher]) }}"
                                                        onclick="return confirm('Apakah anda yakin ? ')"
                                                        class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                </td>
                                                <?php }else { ?>
                                                <td class="text-warning">Terpakai ({{ $v->updated_at }})</td>
                                                <td></td>
                                                <?php } ?>

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
    {{-- modal edit --}}
    @foreach ($disc as $m)
        <form action="{{ route('editMencuci') }}" method="post" accept-charset="utf-8">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit{{ $m->id_discount }}" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content ">
                        <div class="modal-header btn-costume">
                            <h5 class="modal-title text-light" id="exampleModalLabel">Edit mencuci</h5>
                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" name="id_diskon" value="6">

                            <div class="form-group ">
                                <label>Keterangan</label>
                                <div>
                                    <input type="text" name="ket" class="form-control" value="{{ $m->ket }}">
                                </div>
                            </div>

                            <div class="form-group pilih-metode">
                                <label for="">Jenis Diskon</label>
                                <select class="form-control" id="" required="" name="jenis">
                                    <option {{ $m->jenis == 'Rp' ? 'selected' : '' }} value="Rp">Rp</option>
                                    <option {{ $m->jenis == 'Persen' ? 'selected' : '' }} value="Persen">Persen</option>
                                </select>
                            </div>


                            <div class="form-group ">
                                <label>Jumlah Diskon</label>
                                <div>
                                    <input type="number" name="jumlah" class="form-control" value="{{ $m->disc }}">
                                </div>
                                <small class="text-warning">Jika jenis rp (cth: 70000)</small>
                                <small class="text-warning">Jika jenis persen (cth: 10)</small>
                            </div>

                            <div class="form-group ">
                                <label>Dari</label>
                                <div>
                                    <input type="date" name="dari" class="form-control" value="{{ $m->dari }}">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label>Sampai</label>
                                <div>
                                    <input type="date" name="expired" class="form-control" value="{{ $m->expired }}">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary">Edit / Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
    {{-- ---------- --}}
    
    {{-- modal edit --}}
    @foreach ($voucher as $m)
        <form action="{{ route('editVoucher') }}" method="post" accept-charset="utf-8">
            @csrf
            @method('patch')
            <div class="modal fade" id="edit{{ $m->id_voucher }}" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content ">
                        <div class="modal-header btn-costume">
                            <h5 class="modal-title text-light" id="exampleModalLabel">Edit mencuci</h5>
                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <input type="hidden" name="id_voucher" value="{{$m->id_voucher}}">

                            <div class="form-group ">
                                <label>Jumlah</label>
                                <div>
                                    <input type="text" name="jumlah" class="form-control" value="{{ $m->jumlah }}">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label>Keterangan</label>
                                <div>
                                    <input type="text" name="ket" class="form-control" value="{{ $m->ket }}">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label>Tanggal Expired</label>
                                <div>
                                    <input type="date" name="expired" class="form-control" value="{{ $m->expired }}">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary">Edit / Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
    {{-- ---------- --}}
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <style>
        .modal-lg-max {
            max-width: 900px;
        }

    </style>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('.in-discount').change(function() {
                var id = $(this).attr('id');

                $.ajax({
                    method: "GET",
                    url: "<?= route('in_discount') ?>?id=" + id,

                    success: function(hasil) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: ' Discount ' + id + ' berhasil di aktifkan!'
                        });
                    }
                });


            })

            $('.un-discount').change(function() {
                var id = $(this).attr('id');
                $.ajax({
                    method: "GET",
                    url: "<?= route('un_discount') ?>?id=" + id,
                    success: function(hasil) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: ' Discount ' + id + ' berhasil di non-aktifkan!'
                        });
                    }
                });
            })


            $('.in-voucher').change(function() {
                var id = $(this).attr('id');
                var terpakai = $(this).attr('terpakai');

                $.ajax({
                    method: "GET",
                    url: "<?= route('in_voucher') ?>?id=" + id + "&terpakai=" + terpakai,

                    success: function(hasil) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: ' Voucher ' + id + ' berhasil di aktifkan!'
                        });
                    }
                });


            })

            $('.un-voucher').change(function() {
                var id = $(this).attr('id');
                $.ajax({
                    method: "GET",
                    url: "<?= route('un_voucher') ?>?id=" + id,
                    success: function(hasil) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: ' Voucher ' + id + ' berhasil di non-aktifkan!'
                        });
                    }
                });
            })


        })
    </script>
@endsection
