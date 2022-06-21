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


                                <input type="hidden" id="id_lokasi" value="{{$id_lokasi}}">
                                <h5>Data Menu {{ $id_lokasi == 1 ? 'Takemori' : 'Soondobu' }}</h5>
                                <a href="" data-toggle="modal" data-target="#tambah" class="btn btn-info float-right"><i
                                        class="fas fa-plus"></i> Menu</a>
                                <a href="" data-toggle="modal" data-target="#import"
                                    class="mr-2 btn btn-info float-right"><i class="fas fa-file-import"></i> Import Level</a>
                                <!--<a href="" data-toggle="modal" data-target="#import"-->
                                <!--    class="mr-2 btn btn-info float-right"><i class="fas fa-file-import"></i> Import</a>-->
                                <!--<a href="{{ route('exportMenu', ['lokasi' => $id_lokasi]) }}"-->
                                <!--    class="mr-2 btn btn-info float-right"><i class="fas fa-file-excel"></i> Export</a>-->
                                <a href="{{ route('exportMenuLevel', ['lokasi' => $id_lokasi]) }}"
                                    class="mr-2 btn btn-info float-right"><i class="fas fa-file-excel"></i> Export Level</a>
                                <a href="#" data-toggle="modal" data-target="#tbhKategori"
                                    class="mr-2 btn btn-info float-right"><i class="fas fa-plus"></i> Kategori</a>
                                <a href="#" data-toggle="modal" data-target="#tbhHandicap"
                                    class="mr-2 btn btn-info float-right"><i class="fas fa-plus"></i> Level Point</a>
                                
                                
                            </div>
                            @include('flash.flash')
                            <div class="card-body">
                                <input type="text" placeholder="Cari Menu..." class="form-control" id="search_field" name="keyword" autofocus><br>
                                {{-- @livewire('tbl-menu', ['id_lokasi' => $id_lokasi]) --}}
                                <div id="tbl"></div>
                                <div id="tbl2"></div>
                                <div id="pagin"></div>
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
    {{-- update menu --}}
    @foreach ($menu as $m)
        <form action="{{ route('updateMenu') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            @csrf
            <div class="modal fade" id="edit_data{{ $m->id_menu }}" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg-max" role="document">
                    <div class="modal-content ">
                        <div class="modal-header btn-costume">
                            <h5 class="modal-title text-light" id="exampleModalLabel">Edit Menu</h5>
                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="menu">
                                <div class="row">
                                    <input type="hidden" name="id_lokasi" value="{{ $id_lokasi }}">

                                    <div class="col-sm-4 ol-md-6 col-xs-12 mb-2">
                                        <input type="hidden" name="id_menu" value="{{ $m->id_menu }}">
                                        <label for="">Image</label>
                                        <br>
                                        <img width="270"
                                            src="https://upperclassindonesia.com/uploads/tb_menu/CHAWAN MUSHI 1.jpg" alt="">
                                        <br>
                                        <br>
                                        <input type="file" class="form-control" name="image">
                                        <input type="hidden" class="form-control" name="image2"
                                            value="CHAWAN MUSHI 1.jpg">

                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-6 mb-2">
                                                <label for="">
                                                    <dt>Kategori</dt>
                                                </label>
                                                <select name="id_kategori" id="" class="form-control select">
                                                    @foreach ($kategori as $p)
                                                        <option value="{{ $p->kd_kategori }}"
                                                            {{ $p->kd_kategori == $m->id_kategori ? 'selected' : '' }}>
                                                            {{ $p->kategori }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-lg-3 mb-2">
                                                <label for="">
                                                    <dt>Kode Menu</dt>
                                                </label>
                                                <input type="text" readonly name="kd_menu" class="form-control"
                                                    placeholder="Kode Menu" value="{{ $m->kd_menu }}">
                                            </div>
                                            <div class="col-lg-6 mb-2">
                                                <label for="">
                                                    <dt>Nama Menu</dt>
                                                </label>
                                                <input type="text" name="nm_menu" class="form-control"
                                                    placeholder="Nama Menu" value="{{ $m->nm_menu }}">
                                            </div>
                                            <div class="col-lg-6 mb-2">
                                                <label for="">
                                                    <dt>Tipe</dt>
                                                </label>
                                                <select class="form-control select" name="tipe">
                                                    <option {{$m->tipe == 'food' ? 'selected' : ''}} value="food">food</option>
                                                    <option {{$m->tipe == 'drink' ? 'selected' : ''}} value="drink">drink</option>
                                                </select>
                                            </div>
                                            @php
                                                $harga = DB::table('tb_harga')
                                                    ->select('tb_harga.*', 'tb_distribusi.*')
                                                    ->join('tb_distribusi', 'tb_harga.id_distribusi', '=', 'tb_distribusi.id_distribusi')
                                                    ->where('id_menu', $m->id_menu)
                                                    ->get();
                                                $no = 1;
                                                
                                            @endphp
                                            @foreach ($harga as $h)
                                                <div class="col-lg-5 mb-2">
                                                    <label for="">
                                                        <input type="hidden" value="{{ $h->id_harga }}"
                                                            name="id_harga[]">
                                                        <dt>Distribusi</dt>
                                                    </label>
                                                    <select name="id_distribusi[]" id="" class="form-control select">
                                                        @foreach ($distribusi as $d)
                                                            @if ($h->id_distribusi == $d->id_distribusi)
                                                                <option selected value="{{ $h->id_distribusi }}">
                                                                    {{ $h->nm_distribusi }}
                                                                </option>
                                                            @else
                                                                <option value="{{ $d->id_distribusi }}">
                                                                    {{ $d->nm_distribusi }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-5 mb-2">
                                                    <label for="">
                                                        <dt>Harga</dt>
                                                    </label>
                                                    <input type="text" name="harga[]" class="form-control"
                                                        placeholder="Harga" value="{{ $h->harga }}">
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-info">Edit/Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
    <!--tambah kategori-->
    <form action="{{ route('tbhKategori') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal fade" id="tbhKategori" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah Kategori</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="lokasi" value="{{ $id_lokasi }}">
                        <div class="row">
                            @php
                                $lokasi = $id_lokasi == 1 ? 'TAKEMORI' : 'SOONDOBU';            
                                $kategoriKd = DB::table('tb_kategori')
                                ->orderBy('kd_kategori', 'desc')
                                ->where('lokasi', $lokasi)
                                ->first();
                                
                            @endphp
                            <div class="col-lg-3">
                                <label>Kode</label>
                                <input type="number" readonly class="form-control" value="{{$kategoriKd->kd_kategori + 1}}" name="kd_kategori">
                            </div>
                            <div class="col-lg-9">
                                <label>Kategori</label>
                                <input type="text" required class="form-control" name="nm_kategori">
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
    <!-------------------------->
    {{-- import menu --}}
    <form action="{{ route('importMenu') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal fade" id="import1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah menu</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="lokasi" value="{{ $id_lokasi }}">
                        <div class="row">
                            <input type="hidden" name="id_lokasi" value="{{ $id_lokasi }}">
                            <div class="col-sm-4 ol-md-6 col-xs-12 mb-2">
                                <label for="">Masukkan Gambar</label>
                                <input type="file" data-height="150" name="file">
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
    {{-- import menu --}}
    <form action="{{ route('importMenuLevel') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal fade" id="import" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-md" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah menu</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="lokasi" value="{{ $id_lokasi }}">
                        <div class="row">
                            <input type="hidden" name="id_lokasi" value="{{ $id_lokasi }}">
                            <div class="col-sm-4 ol-md-6 col-xs-12 mb-2">
                                <label for="">Masukkan File</label>
                                <input type="file" data-height="150" name="file">
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
    <!-- tambah handicap -->
    <form action="{{route('tbhHenKategori')}}" method="post" accept-charset="utf-8">
    @csrf
    <div class="modal fade" id="tbhHandicap" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header btn-costume">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Tambah data</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id_lokasi" value="{{ $id_lokasi }}">
                        <div class="col-lg-3">
                            <label for="">Level</label>
                           <input type="text" class="form-control" name="handicap">
                            
                        </div>
                        <div class="col-lg-6">
                            <label for="">Keterangan</label>
                           <input type="text" class="form-control" name="ket">
                            
                        </div>
                        <div class="col-lg-3">
                            <label for="">Point</label>
                            <input required type="number" name="point" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                        <table id="example1" class="table">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Level</td>
                                    <td>Keterangan</td>
                                    <td>Point</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach($handicap as $h)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$h->handicap}}</td>
                                    <td>{{$h->ket}}</td>
                                    <td>{{$h->point}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    <!-- --------------------------- -->
    {{-- tambah distribusi --}}
    @foreach ($menu as $m)
        <form action="{{ route('plusDistribusi') }}" method="post">
            @csrf
            <div class="modal fade" id="distribusi<?= $m->id_menu ?>" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content ">
                        <div class="modal-header btn-costume">
                            <h5 class="modal-title text-light" id="exampleModalLabel"><?= $m->nm_menu ?></h5>
                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 mb-2">
                                    <input type="hidden" name="id_lokasi" value="{{ $id_lokasi }}">
                                    <label for="">
                                        <dt>Distribusi</dt>
                                    </label>
                                    <select name="id_distribusi" id="" class="form-control select">
                                        <option value="">-Pilih distribusi-</option>
                                        <?php foreach ($distribusi as $d) : ?>
                                        <option value="<?= $d->id_distribusi ?>"><?= $d->nm_distribusi ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">
                                        <dt>Harga</dt>
                                    </label>
                                    <input type="text" name="harga" class="form-control" placeholder="Harga">
                                    <input type="hidden" name="id_menu" class="form-control" value="<?= $m->id_menu ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-info">Edit/Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
    {{-- ------------------- --}}

    {{-- tambah menu --}}
    <form action="{{ route('addMenu') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah menu</h5>
                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id_lokasi" value="{{ $id_lokasi }}">
                            <div class="col-sm-4 ol-md-6 col-xs-12 mb-2">
                                <label for="">Masukkan Gambar</label>
                                <input type="file" class="dropify" data-height="150" name="image"
                                    placeholder="Image">
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Kategori</dt>
                                        </label>
                                        <select name="id_kategori" id="" class="form-control select">
                                            <option value="">-Pilih Kategori-</option>
                                            @foreach ($kategori as $m)
                                                <option value="{{ $m->kd_kategori }}">{{ $m->kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">
                                            <dt>Level Point</dt>
                                        </label>
                                        <select name="id_handicap" id="" class="form-control select">
                                            <option value="">-Pilih Level-</option>
                                            @foreach ($handicap as $m)
                                                <option value="{{ $m->id_handicap }}">{{ $m->handicap }} ({{$m->point}} Point)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 mb-2">
                                        <label for="">
                                            <dt>Kode Menu</dt>
                                        </label>
                                        @php
                                            $menu = DB::table('tb_menu')
                                                ->orderBy('kd_menu', 'desc')
                                                ->where('lokasi', $id_lokasi)
                                                ->first();
                                        @endphp
                                        <input readonly type="text" name="kd_menu" class="form-control"
                                            placeholder="Kode Menu" value="{{ $menu->kd_menu + 1 }}">
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Nama Menu</dt>
                                        </label>
                                        <input type="text" name="nm_menu" class="form-control" placeholder="Nama Menu">
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label for="">
                                            <dt>Tipe</dt>
                                        </label>
                                        <Select class="form-control select" name="tipe">
                                            <option value="">-Pilih tipe-</option>
                                            <option value="food">Food</option>
                                            <option value="drink">Drink</option>
                                        </Select>
                                    </div>

                                    <div class="col-lg-5 mb-2">
                                        <label for="">
                                            <dt>Distribusi</dt>
                                        </label>
                                        <select name="id_distribusi[]" id="" class="form-control select">
                                            <option value="">-Pilih distribusi-</option>
                                            <option value="1">DINE-IN / TAKEWAY</option>
                                            <option value="2">GOJEK</option>
                                            <option value="3">DELIVERY</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-5 mb-2">
                                        <label for="">
                                            <dt>Harga</dt>
                                        </label>
                                        <input type="text" name="harga[]" class="form-control" placeholder="Harga">
                                    </div>

                                    <div class="col-lg-2 mb-2">
                                        <label for="">
                                            <dt>Aksi</dt>
                                        </label> <br>
                                        <button href="" id="tambah_distribusi" type="button"
                                            class="btn btn-sm btn-info "><i class="fas fa-plus"></i></button>
                                    </div>

                                </div>
                                <div id="p_pakan">

                                </div>
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
        {{-- akhir tambah menu --}}
    @endsection
    @section('script')
        <script>
            $(document).ready(function() {

                var count_monitoring = 1;
                $('#tambah_distribusi').click(function() {
                    count_monitoring = count_monitoring + 1;
                    // var no_nota_atk = $("#no_nota_atk").val();
                    var html_code = "<div class='row' id='row_stk" + count_monitoring + "'>";


                    html_code +=
                        '<div class="col-md-5 col-3"><div class="form-group"><select name="id_distribusi[]" id="" class="form-control select"><option value="">-Pilih distribusi-</option><option value="1">DINE-IN / TAKEWAY</option><option value="2">GOJEK</option><option value="3">DELIVERY</option></select></div></div>';

                    html_code +=
                        '<div class="col-md-5 col-3"><div class="form-group"><input type="text" name="harga[]" class="form-control hasil" id="hasil' +
                        count_monitoring + '" placeholder="Harga"></div></div>';

                    html_code +=
                        ' <div class="col-md-2 col-1"><button type="button" name="remove" data-row="row_stk' +
                        count_monitoring +
                        '" class="btn btn-danger btn-sm remove_stk"><i class="fas fa-minus"></i></button></div>';


                    html_code += "</div>";

                    $('#p_pakan').append(html_code);
                    $('.select').select2()
                });



                $(document).on('click', '.remove_stk', function() {
                    var delete_row = $(this).data("row");
                    $('#' + delete_row).remove();
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                

                $(document).on('click', '.edit_menu', function() {
                    var id_menu = $(this).attr("id_menu");
                    $.ajax({
                        url: "",
                        method: "POST",
                        data: {
                            id_menu: id_menu,
                        },
                        success: function(data) {
                            $('#menu').html(data);
                        }
                    });

                });
                loadMenu(1)
                $(document).on('click', '.page-link', function(event) {
                    event.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    loadMenu(page);
                });
                function switchBox(){
                    $('.form-checkbox1').click(function() {

                    var id_checkbox = $(this).attr("id_checkbox");
                    // alert(id_checkbox)
                    if ($(this).is(':checked')) {
                        var nilai1 = 'on';
                        $('.nilai' + id_checkbox).val(nilai1);
                    } else {
                        var nilai1 = 'off';
                        $('.nilai' + id_checkbox).val(nilai1);
                    }
                        $.ajax({
                            method: "POST",
                            url: "{{ route('editMenuCheck') }}",
                            data: {
                                id_checkbox: id_checkbox,
                                nilai1: nilai1,
                                '_token': "{{ csrf_token() }}"
                            },

                            success: function(hasil) {
                                if (nilai1 == 'on') {
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        icon: 'success',
                                        title: 'Data menu telah di on kan'
                                    });
                                } else {
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        icon: 'error',
                                        title: 'Data menu telah di off kan'
                                    });
                                }
                            }
                        });
                    });
                }

                function loadMenu(page) {
                    var id_lokasi = $("#id_lokasi").val()
                
                    $("#tbl").load("{{ route('tblMenu') }}?id_lokasi="+id_lokasi+"&page="+page, "data", function (response, status, request) {
                        this; // dom element

                        switchBox()
                        
                    });
                }
                $('#search_field').keyup(function() {
                    // alert(1)
                    var keyword = $("#search_field").val();
                    if (keyword != '') {
                        $('#tbl2').show();
                        $('#tbl').hide();
                        load_data(keyword);
                        
                    } else {
                        $('#tbl2').hide();
                        $('#tbl').show();
                    }

                });
                function load_data(keyword) {
                var id_lokasi = $("#id_lokasi").val()
                $.ajax({
                    method: "GET",
                    url: "{{ route('cariMenu') }}",
                    data: {
                        keyword: keyword,
                        id_lokasi: id_lokasi
                    },
                    success: function(hasil) {
                        $('#tbl2').html(hasil);
                        switchBox()
                    }
                });
            }

            });                 
        </script>
    @endsection
