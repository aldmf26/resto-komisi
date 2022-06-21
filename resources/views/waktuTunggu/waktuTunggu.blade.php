@extends('template.master')
@section('content')
@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
    <style>
        /* .icon-menu:hover{
            background: #C8BED8;
            border-radius: 50px;
        } */

        h6 {
            color: #155592;
            font-weight: bold;
        }

    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 justify-content-center">
                    <div class="col-sm-12">
                        <center>
                            <h4 style="color: #787878; font-weight: bold;">Waktu tunggu</h4>
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
                                <form action="<?= route('addWaktuTunggu') ?>" method="post">
                                    @csrf
                                    <div class="row">

                                        <div class="col-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <button type="submit" name="batas"
                                                        onclick="return confirm('Apakah anda yakin?')"
                                                        class="btn-block btn btn-info" value="30"
                                                        <?= $cek ? 'disabled' : '' ?>>30 menit</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <button type="submit" name="batas"
                                                        onclick="return confirm('Apakah anda yakin?')"
                                                        class="btn-block btn btn-info" value="45"
                                                        <?= $cek ? 'disabled' : '' ?>>45 menit</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <button type="submit" name="batas"
                                                        onclick="return confirm('Apakah anda yakin?')"
                                                        class="btn-block btn btn-info" value="60"
                                                        <?= $cek ? 'disabled' : '' ?>>1 jam</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <table class="table  " id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jam Buat</th>
                                            <th>Jam Selesai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                    foreach ($peringatan as $d) :
                                    ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= date('H:i', strtotime($d->jam_buat)) ?></td>
                                            <td><?= date('H:i', strtotime($d->jam_akhir)) ?></td>
                                            <td>
                                                <!-- <a href="#edit<?= $d->id_tips ?>" data-toggle="modal" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a> -->
                                                <a href="<?= route('hapusWaktuTunggu', ['id_peringatan' => $d->id_peringatan]) ?>"
                                                    onclick="return confirm('Apakah anda yakin?')"
                                                    class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                            </td>

                                        </tr>
                                        <?php endforeach ?>
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
@endsection




<!-- /.control-sidebar -->


@section('script')
    <script>
        function selection() {
            var selected = document.getElementById("select1").value;
            if (selected == 0) {
                document.getElementById("input1").removeAttribute("hidden");
            } else {
                //elsewhere actions
            }
        }
    </script>
@endsection
