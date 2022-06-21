@extends('template.master')
@section('content')
    <?php
    $dt = date('Y-m-d');
    date_default_timezone_set('Asia/Jakarta');
    ?>
    <style>
        .nav-pills .nav-link.active {
            color: #fff;
            background-color: #00A549;
            box-shadow: 0px 10px 20px 0px rgba(50, 50, 50, 0.52)
        }

        .nav {
            white-space: nowrap;
            display: block !important;
            flex-wrap: nowrap;
            max-width: 100%;
            overflow-x: scroll;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch
        }

        .nav li {
            display: inline-block
        }

        input[type=number] {
            /for absolutely positioning spinners/ position: relative;
            padding: 5px;
            padding-right: 25px;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            opacity: 1;
        }

        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: inner-spin-button !important;
            width: 25px;
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
        }

        .custom-scrollbar-js,
        .custom-scrollbar-css {
            height: 75px;
        }


        /* Custom Scrollbar using CSS */
        .custom-scrollbar-css {
            overflow-y: scroll;
        }

        /* scrollbar width */
        .custom-scrollbar-css::-webkit-scrollbar {
            width: 3px;
        }

        /* scrollbar track */
        .custom-scrollbar-css::-webkit-scrollbar-track {
            background: #EEE;
        }

        /* scrollbar handle */
        .custom-scrollbar-css::-webkit-scrollbar-thumb {
            border-radius: 1rem;
            background: #26C784;
            background: -webkit-linear-gradient(to right, #11998e, #26C784);
            background: linear-gradient(to right, #11998e, #26C784);
        }

    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    @foreach ($distribusi as $d)
                        <div class="col-md-3 col-6">
                            <div class="card bg-gradient">
                                <div class="card-body">
                                    <nav class=" nav-pills nav-fill">
                                        <?php if ($d->id_distribusi == $id_dis) : ?>
                                        <a class="nav-item nav-link active"
                                            href="{{ route('order', ['dis' => $d->id_distribusi]) }}"
                                            style="font-weight: bold; color: #fff;">{{ $d->nm_distribusi }}</a>
                                        <?php else : ?>
                                        <a class="nav-item nav-link "
                                            href="{{ route('order', ['dis' => $d->id_distribusi]) }}"
                                            style="font-weight: bold; color: #fff;">{{ $d->nm_distribusi }}</a>
                                        <?php endif ?>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-3 col-6" id="peringatan">

                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3 custom-scrollbar-css" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                            role="tab" aria-controls="pills-home" aria-selected="true"><i
                                                class="fa fa-search"></i></a>
                                    </li>
                                    @foreach ($kategori as $k)
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill"
                                                href="#{{ $k->ket }}" role="tab" aria-controls="pills-profile"
                                                aria-selected="false"><strong>{{ $k->kategori }}</strong></a>
                                        </li>
                                    @endforeach


                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input type="hidden" id='dis' value="<?= $id ?>">
                        <input type="hidden" id='dis2' value="<?= $id_dis ?>">

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="text" name="search_text" id="search_field" class="form-control"
                                            placeholder="Cari Menu . . ." />
                                    </div>
                                </div>
                                <div id="demonames">
                                    <div id="menu">

                                    </div>
                                    <div id="result2">

                                    </div>
                                </div>
                            </div>
                            @php
                                $tgl = date('Y-m-d');
                                $id_lokasi = Session::get('id_lokasi');
                                $sold_out = DB::table('tb_sold_out')
                                    ->where('tgl', $tgl)
                                    ->get();
                                $id_menu_sold_out = [];
                                foreach ($sold_out as $s) {
                                    $id_menu_sold_out[] = $s->id_menu;
                                }
                                
                                $idl = [];
                                $limit = DB::select("SELECT tb_menu.id_menu as id_menu FROM tb_menu
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        LEFT JOIN(SELECT SUM(qty) as jml_jual, tb_harga.id_menu FROM tb_order LEFT JOIN tb_harga ON tb_order.id_harga = tb_harga.id_harga WHERE tb_order.id_lokasi = $id_lokasi AND tb_order.tgl = '$tgl' AND tb_order.void = 0 GROUP BY tb_harga.id_menu) dt_order ON tb_menu.id_menu = dt_order.id_menu
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        LEFT JOIN(SELECT id_menu,batas_limit FROM tb_limit WHERE tgl = '$tgl' AND id_lokasi = $id_lokasi GROUP BY id_menu)dt_limit ON tb_menu.id_menu = dt_limit.id_menu
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        WHERE lokasi = $id_lokasi AND dt_order.jml_jual >= dt_limit.batas_limit");
                                foreach ($limit as $l) {
                                    $idl[] = $l->id_menu;
                                }
                            @endphp
                            @foreach ($kategori as $k)
                                <div class="tab-pane fade" id="{{ $k->ket }}" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    <div class="row">
                                        @php
                                            $menu = DB::table('view_menu_kategori')
                                                ->join('tb_menu', 'view_menu_kategori.id_menu', 'tb_menu.id_menu')
                                                ->where('view_menu_kategori.lokasi', $id_lokasi)
                                                ->where('view_menu_kategori.id_distribusi', $id)
                                                ->where('view_menu_kategori.id_kategori', $k->kd_kategori)
                                                ->where('tb_menu.aktif', 'on')
                                                ->whereNotIn('view_menu_kategori.id_menu', $id_menu_sold_out)
                                                ->whereNotIn('view_menu_kategori.id_menu', $idl)
                                                ->get();
                                        @endphp

                                        @foreach ($menu as $t)
                                            <div class="col-md-3">
                                                <a href="" class="input_cart2" data-toggle="modal" data-target="#myModal"
                                                    id_harga="{{ $t->id_harga }}" id_dis="{{ $id_dis }}">
                                                    <div class="card">
                                                        <div
                                                            style="background-color: rgba(0, 0, 0, 0.5); padding:5px 0 5px;">
                                                            <h6 style="font-weight: bold; color:#fff;"
                                                                class="text-center">
                                                                {{ ucwords(Str::lower($t->nm_menu)) }}

                                                            </h6>
                                                        </div>
                                                        <div class="card-body" style="padding:0.2rem;">
                                                            <p class="mt-2 text-center demoname"
                                                                style="font-size:15px; color: #787878;"><strong>Rp.
                                                                    {{ number_format($t->harga) }}</strong></p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('payment') }}" method="get">
                            <input type="hidden" name="distribusi" value="<?= $id_dis ?>">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="text-center" style="font-weight: bold;">KERANJANG BELANJA</h4>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="">Meja</label>
                                            <select name="meja" id="meja" class="form-control select2bs4">

                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="">Orang</label>
                                            <input type="number" name="orang" class="form-control" value="1">
                                            <input type="hidden" class="form-control id_distribusi"
                                                value="{{ $id_distri->id_distribusi }}">
                                        </div>
                                    </div>


                                    <hr>
                                    <div id="keranjang">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    <form method="get" class="input_cart">
        <div class="modal fade modal-cart" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div id="harga"></div>
            </div>
        </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var dis = $("#dis").val();
            var dis2 = $("#dis2").val();
            load_menu(1);

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                load_menu(page);
            });


            setInterval(function() {
                $("#peringatan").load("{{ route('get_peringatan') }}", "data", function(response, status,
                    request) {
                    this; // dom element

                });

            }, 1000);




            function load_menu(page) {
                var dis = $("#dis").val();
                var dis2 = $("#dis2").val();
                // console.log(dis);
                // alert(page);
                console.log(page);
                $.ajax({
                    method: "GET",

                    url: "{{ route('get_order') }}?page=" + page + "&id_dis=" + dis + "&id_dis2=" + dis2,
                    dataType: "html",
                    success: function(hasil) {
                        $('#menu').html(hasil);
                    }
                });
            }
            $('#search_field').keyup(function() {
                var keyword = $("#search_field").val();
                if (keyword != '') {
                    $('#result2').show();
                    $('#menu').hide();
                    load_data(keyword);
                } else {
                    $('#result2').hide();
                    $('#menu').show();
                }

            });

            function load_data(keyword) {
                $.ajax({
                    method: "GET",
                    url: "{{ route('search') }}",
                    data: {
                        keyword: keyword,
                        dis: dis,
                        dis2: dis2,
                    },
                    success: function(hasil) {
                        $('#result2').html(hasil);
                    }
                });
            }

            $(document).on('click', '.input_cart2', function() {
                var id_harga = $(this).attr("id_harga");
                var id_dis = $(this).attr("id_dis");

                // console.log(id_harga);
                $.ajax({
                    url: "{{ route('item_menu') }}",
                    method: "GET",
                    data: {
                        id_harga: id_harga,
                        id_dis: id_dis,
                    },
                    success: function(data) {
                        $('#harga').html(data);
                        // alert(data);
                    }
                });

            });


            load_cart();

            function load_cart() {
                var dis2 = $("#dis2").val();
                $.ajax({
                    method: "GET",
                    url: "{{ route('keranjang') }}?dis=" + dis2,
                    success: function(hasil) {
                        $('#keranjang').html(hasil);
                    }
                });
            }

            $(document).on('submit', '.input_cart', function(event) {
                event.preventDefault();
                $('.btn_to_cart').hide();
                var id_harga2 = $("#id_harga2").val();
                var price = $("#price").val();
                var name = $("#name").val();
                var qty = $("#qty").val();
                var id_menu = $("#id_menu").val();
                var req = $("#req").val();
                $.ajax({
                    url: "{{ route('cart') }}",
                    method: 'GET',
                    data: {
                        id_harga2: id_harga2,
                        price: price,
                        name: name,
                        qty: qty,
                        req: req,
                        id_menu: id_menu,
                    },
                    success: function(data) {
                        if (data == 'berhasil') {
                            $('#cart_session').html(data);
                            $('.modal-cart').modal('hide');
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data berhasil ditambahkan'
                            });
                            load_cart();
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: 'Jumlah melebihi batas limit, Maksimal order ' +
                                    data + ' porsi'
                            });
                        }
                    }
                });
            });

            $(document).on('click', '.delete_cart', function(event) {
                var rowid = $(this).attr("id");
                // alert(rowId);
                $.ajax({
                    url: "{{ route('delete_order') }}",
                    method: "GET",
                    data: {
                        rowid: rowid
                    },
                    success: function(data) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Item dihapus dari keranjang'
                        });
                        $('#cart_session').html(data);
                        load_cart();
                    }
                });
            });

            $(document).on('click', '.min_cart', function(event) {
                var rowid = $(this).attr("id");
                var qty = $(this).attr("qty");

                // alert(qty);
                $.ajax({
                    url: "{{ route('min_cart') }}",
                    method: "GET",
                    data: {
                        rowid: rowid,
                        qty: qty
                    },
                    success: function(data) {
                        // $('#cart_session').html(data); 
                        load_cart();
                    }
                });
            });
            $(document).on('click', '.plus_cart', function(event) {
                var rowid = $(this).attr("id");
                var qty = $(this).attr("qty");

                // alert(qty);
                $.ajax({
                    url: "{{ route('plus_cart') }}",
                    method: "GET",
                    data: {
                        rowid: rowid,
                        qty: qty
                    },
                    success: function(data) {
                        // $('#cart_session').html(data); 
                        load_cart();
                    }
                });
            });

            get_meja(1);

            function get_meja(dis) {
                var dis2 = $("#dis2").val();
                $.ajax({
                    method: "GET",
                    url: "{{ route('get_meja') }}?dis=" + dis2,
                    dataType: "html",
                    success: function(hasil) {
                        $('#meja').html(hasil);
                    }
                });
            }
        });
    </script>
@endsection
