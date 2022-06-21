@extends('template.master')
@section('content')
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
    <style>
        /* card active */
        .buying-selling.active {
            background-image: linear-gradient(to right, #00B7B5 0%, #00B7B5 19%, #019392 60%, #04817F 100%);
        }
    
        .option1 {
            display: none;
        }
    
        .buying-selling {
            width: 123px;
            padding: 10px;
            position: relative;
        }
    
        .buying-selling-word {
            font-size: 10px;
            font-weight: 600;
            margin-left: 35px;
        }
    
        .radio-dot:before,
        .radio-dot:after {
            content: "";
            display: block;
            position: absolute;
            background: #fff;
            border-radius: 100%;
        }
    
        .radio-dot:before {
            width: 20px;
            height: 20px;
            border: 1px solid #ccc;
            top: 10px;
            left: 16px;
        }
    
        .radio-dot:after {
            width: 12px;
            height: 12px;
            border-radius: 100%;
            top: 14px;
            left: 20px;
        }
    
        .buying-selling.active .buying-selling-word {
            color: #fff;
        }
    
        .buying-selling.active .radio-dot:after {
            background-image: linear-gradient(to right, #00B7B5 0%, #00B7B5 19%, #019392 60%, #04817F 100%);
        }
    
        .buying-selling.active .radio-dot:before {
            background: #fff;
            border-color: #699D17;
        }
    
        .buying-selling:hover .radio-dot:before {
            border-color: #adadad;
        }
    
        .buying-selling.active:hover .radio-dot:before {
            border-color: #699D17;
        }
    
    
        /* .buying-selling.active .radio-dot:after {
            background-image: linear-gradient(to right, #f78ca0 0%, #f9748f 19%, #fd868c 60%, #fe9a8b 100%);
        } */
    
        /* dot */
        .buying-selling:hover .radio-dot:after {
            background-image: linear-gradient(to right, #00B7B5 0%, #00B7B5 19%, #019392 60%, #04817F 100%);
        }
    
        /* .buying-selling.active:hover .radio-dot:after {
            background-image: linear-gradient(to right, #f78ca0 0%, #f9748f 19%, #fd868c 60%, #fe9a8b 100%);
    
        } */
    
        @media (max-width: 400px) {
    
            .mobile-br {
                display: none;
            }
    
            .buying-selling {
                width: 49%;
                padding: 10px;
                position: relative;
            }
    
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2 justify-content-center">
                    <div class="col-sm-12">
                        <center>
                            <h4 style="color: #787878; font-weight: bold;">Orderan</h4>
                        </center>

                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <a class="btn btn-info float-right" data-toggle="modal" data-target="#view"><i
                                class="fas fa-eye"></i> View</a>
                        <br>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <table class="table  " id="table" width="100%" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 12px;">No</th>
                                            <th style="font-size: 12px;">No Order</th>
                                            <th style="font-size: 12px;">Table</th>
                                            <th style="font-size: 12px;">Menu</th>
                                            <th style="font-size: 12px;">Qty</th>
                                            <th style="font-size: 12px;">Harga</th>
                                            <th style="font-size: 12px;">Time Order</th>
                                            <th style="font-size: 12px;">Server</th>
                                            <th style="font-size: 12px;">Koki</th>
                                            <th style="font-size: 12px;">Waitress</th>
                                            <th style="font-size: 12px;">Time Delay</th>
                                            <th style="font-size: 12px;">Status</th>
                                            <th style="font-size: 12px;">Admin</th>
                                            <th style="font-size: 12px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                    foreach ($tb_order as $t) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $t->no_order ?></td>
                                            <td><?= $t->nm_meja ?></td>
                                            <td><?= $t->nm_menu ?></td>
                                            <td><?= $t->qty ?></td>
                                            <td><?= number_format($t->qty * $t->harga, 0) ?></td>
                                            <?php $waktu1 = new DateTime($t->j_mulai); ?>
                                            <td><?= $waktu1->format('h.i A') ?></td>
                                            <td><?= $t->admin ?></td>
                                            <td style="white-space: nowrap;">
                                                <?= $t->koki1 ?>,<?= $t->koki2 ?>,<?= $t->koki3 ?></td>
                                            <td><?= $t->pengantar ?></td>
                                            <td><?= number_format($t->selisih, 0) ?></td>
                                            <td><?= $t->selesai ?></td>
                                            <td><a href="#" class="btnAdmin" admin="{{$t->admin}}" data-target="#editAdmin{{$t->id_order}}" data-toggle="modal" ><?= $t->admin ?></a></td>
                                            <td style="white-space: nowrap;">
                                                <?php if ($t->selesai == 'dimasak'){ ?>
                                                <a href="<?= route('drop', ['id' => $t->id_order]) ?>"
                                                    onclick="return confirm('Apakah anda yakin ingn menghapus pesanan?')"
                                                    class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>
                                                <button class="btn btn-xs btn-info" data-target="#edit<?= $t->id_order ?>"
                                                    data-toggle="modal"><i class="fas fa-edit"></i></button>
                                                <?php }else { ?>
                                                <?php if(Auth::user()->id_posisi != 2 && $t->aktif == 1){ ?>
                                                <button class="btn btn-xs btn-danger" data-target="#void<?= $t->id_order ?>"
                                                    data-toggle="modal">Void</button>
                                                <?php }?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <form action="<?= route('order1') ?>" method="get">
                        <div class="modal fade" id="view">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h4 class="modal-title">View</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <label for="">Dari</label>
                                                    <input type="date" name="tgl" class="form-control">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="">Sampai</label>
                                                    <input type="date" name="tgl2" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" target="_blank">Lanjutkan</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <?php foreach($tb_order as $o): ?>

                    <form action="<?= route('edit_order') ?>" method="post">
                        @csrf
                        <div class="modal fade" id="edit<?= $o->id_order ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h4 class="modal-title">Edit Orderan</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="row">

                                            <input type="hidden" name="id_order" value="<?= $o->id_order ?>">

                                            <div class="col-6">
                                                <div class="from-group">
                                                    <label for="">Menu</label>
                                                    <input type="text" class="form-control" value="<?= $o->nm_menu ?>"
                                                        disabled>
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="from-group">
                                                    <label for="">Qty</label>
                                                    <input type="number" name="qty" class="form-control"
                                                        value="<?= $o->qty ?>">
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="from-group">
                                                    <label for="">Harga</label>
                                                    <input type="number" class="form-control" value="<?= $o->harga ?>"
                                                        disabled>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="from-group">
                                                    <label for="">Request</label>
                                                    <input type="text" name="request" class="form-control"
                                                        value="<?= $o->request ?>">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" target="_blank">Lanjutkan</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>
                </form>

                {{-- edit admin --}}
                    <form action="<?= route('edit_orderAdmin') ?>" method="post">
                        @csrf
                        <div class="modal fade" id="editAdmin<?= $o->id_order ?>">
                            <div class="modal-dialog modal-lg-max">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h4 class="modal-title">Edit Admin</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="row">
                                            {{-- <input type="hidden" class="admin" name="admin" value="{{ $o->admin }}"> --}}
                                            <input type="hidden" name="id_order" value="<?= $o->id_order ?>">
                                            <input type="hidden" name="dari" value="<?= Request::get('tgl') ?>">
                                            <input type="hidden" name="sampai" value="<?= Request::get('tgl2') ?>">

                                            <div class="buying-selling-group" id="buying-selling-group" data-toggle="buttons">

                                            </div>
                                            

                                            

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Edit/Save</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>
                </form>
                {{-- ------------------------ --}}

                <form action="<?= route('void') ?>" method="post">
                    @csrf
                    <div class="modal fade  modal-lg-max" id="void<?= $o->id_order ?>">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h4 class="modal-title">Void Orderan</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="row">

                                        <input type="hidden" name="id_order" value="<?= $o->id_order ?>">

                                        <div class="col-12">
                                            <div class="from-group">
                                                <label for="">Keterangan Void</label>
                                                <input type="text" class="form-control" name="alasan">
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Void</button>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
            </form>

            <?php endforeach; ?>

        


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






    <!-- /.control-sidebar -->
@endsection
@section('script')
    <script>
        $('.select2bs4').select2({
                            theme: 'bootstrap4'
                        });
        $(document).ready(function() {

            load_tugas();

            function load_tugas() {
                $.ajax({
                    method: "GET",
                    url: "<?= route('get_head') ?>",
                    dataType: "html",
                    success: function(hasil) {
                        $('#tugas_head').html(hasil);
                    }
                });
            }

            // user
            $(document).on('click', '.btnAdmin', function(){
                var admin = $(this).attr('admin')
                // alert(admin)
                $.ajax({
                    url: "{{route('get_user')}}?admin="+admin,
                    method: "GET",
                    success:function(data){
                        $(".buying-selling-group").html(data)
                    }
                })
            })

            
            $(document).on('click', '.koki1', function(event) {
                var kode = $(this).attr('kode');
                var kry = $(this).attr('kry');
                $.ajax({
                    type: "POST",
                    url: "<?= route('koki1') ?>",
                    data: {
                        kode: kode,
                        kry: kry
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Koki 1 berhasil ditambahkan'
                        });
                        load_tugas();
                    }
                });
            });


            $(document).on('click', '.koki2', function(event) {

                var kode = $(this).attr('kode');
                var kry = $(this).attr('kry');
                $.ajax({
                    type: "POST",
                    url: "<?= route('koki2') ?>",
                    data: {
                        kode: kode,
                        kry: kry
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Koki 2 berhasil ditambahkan'
                        });
                        load_tugas();
                    }
                });
            });

            $(document).on('click', '.koki3', function(event) {
                var kode = $(this).attr('kode');
                var kry = $(this).attr('kry');
                $.ajax({
                    type: "POST",
                    url: "<?= route('koki3') ?>",
                    data: {
                        kode: kode,
                        kry: kry
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Koki 3 berhasil ditambahkan'
                        });
                        load_tugas();
                    }
                });
            });

            $(document).on('click', '.un_koki1', function(event) {
                var kode = $(this).attr('kode');
                $.ajax({
                    type: "POST",
                    url: "<?= route('un_koki1') ?>",
                    data: {
                        kode: kode
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Koki 1 dibatalkan'
                        });
                        load_tugas();
                    }
                });
            });
            $(document).on('click', '.un_koki2', function(event) {
                var kode = $(this).attr('kode');
                $.ajax({
                    type: "POST",
                    url: "<?= route('koki2') ?>",
                    data: {
                        kode: kode
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Koki 2 dibatalkan'
                        });
                        load_tugas();
                    }
                });
            });
            $(document).on('click', '.un_koki3', function(event) {
                var kode = $(this).attr('kode');
                $.ajax({
                    type: "POST",
                    url: "<?= route('un_koki3') ?>",
                    data: {
                        kode: kode
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Koki 3 dibatalkan'
                        });
                        load_tugas();
                    }
                });
            });
            $(document).on('click', '.selesai', function(event) {
                var kode = $(this).attr('kode');
                $.ajax({
                    type: "POST",
                    url: "<?= route('head_selesei') ?>",
                    data: {
                        kode: kode
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Makanan telah selesai'
                        });
                        load_tugas();
                    }
                });
            });
            $(document).on('click', '.gagal', function(event) {

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'error',
                    title: 'Koki belum di pilih'
                });
                load_tugas();


            });



        });
    </script>



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
