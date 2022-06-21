@extends('template.master')
@section('content')
<style>
    #urutan {
        opacity: -1;
    }

    #urutan:hover {
        color: yellow;
        border: 1px solid yellow;
        opacity: 1;
    }

    #tbhMenu {
        opacity: -1;
    }

    #tbhMenu:hover {
        color: yellow;
        border: 1px solid yellow;
        opacity: 1;
    }
</style>
<div class="content-wrapper" style="min-height: 511px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2 justify-content-center">
                <div class="col-lg-12">
                    <h3 class="text-center">Vocher Hapus</h3>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8">
            <div class="card ">
                <div class="card-header ">
                    <a href="{{route('tbh_voucher_hapus')}}" class="btn btn-info btn-sm float-right"><i
                            class="fas fa-plus"></i> Tambah data</a>
                </div>
                <div class="card-body">

                    <table class="table dataTable no-footer" id="table" role="grid" aria-describedby="table_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Kode voucher</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1?>
                            @foreach ($voucher as $v)
                            <tr>
                                <td>
                                    <?= $i++ ?>
                                </td>
                                <td>
                                    <?= $v->kode_voucher ?>
                                </td>
                                <td>
                                    <?= $v->status == 'Y'?'Terpakai':'Belum terpakai' ?>
                                </td>
                                <td><a href="{{route('hapus_voucher_hapus')}}?id_voucher={{$v->id_voucher}}" class="btn
                                        btn-danger
                                        btn-sm"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

    <!-- Main content -->

    <!-- /.content -->
</div>
<form action="">
    <div class="modal fade" id="tambah">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-info ">
                    <h4 class="modal-title">Tambah data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <label for="">Masukan voucher</label>
                                <input type="text" name="voucher" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-info" target="_blank">Lanjutkan</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>


@endsection
@section('script')
{{-- <script>
    $(document).ready(function() {
            $('#adminMenu').load("{{ route('adminMenu') }}", "data", function(response, status, request) {
                this; // dom element

            });

            $('#restoMenu').load("{{ route('restoMenu') }}", "data", function(response, status, request) {
                this; // dom element

            });
        })
</script> --}}
@endsection