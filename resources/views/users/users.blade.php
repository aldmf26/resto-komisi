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

    </style>
    <div class="content-wrapper" style="min-height: 511px;">
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
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="pt-2 px-3">
                                <h3 class="card-title">Data User</h3>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $jenis == 'adm' ? 'active' : '' }}"
                                    href="{{ route('users') }}?jenis=adm">Administrator</a>
                            </li>
                            <li class="nav-item">
                                <a id="aTkm" class="nav-link {{ $jenis == 'tkm' ? 'active' : '' }}"
                                    href="{{ route('users') }}?jenis=tkm">Takemori</a>
                            </li>
                            <li class="nav-item">
                                <a id="aSdb" class="nav-link {{ $jenis == 'sdb' ? 'active' : '' }}"
                                    href="{{ route('users') }}?jenis=sdb">Soondobu</a>
                            </li>
                            <li class="nav-item">
                                <a href="" data-toggle="modal" data-target="#tambah" class="btn  btn-info"><i
                                        class="fas fa-plus"></i>Tambah User</a>
                            </li>
                            <li class="nav-item">
                                <button data-toggle="modal" id="urutan" data-target="#urutanPermission"
                                    class="mt-2 ml-1"><i class="fas fa-list"></i></button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-two-tabContent">
                            <div class="tab-pane fade show active">
                                <div class="card-body">
                                    <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table dataTable no-footer" id="table" role="grid"
                                                    aria-describedby="table_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>#</th>
                                                            <th>Nama</th>
                                                            <th>Username</th>
                                                            <th>Posisi</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @foreach ($users as $u)
                                                            @php
                                                                if ($u->id_posisi == 6) {
                                                                    $posisi = 'Asisten Cook';
                                                                } elseif ($u->id_posisi == 2) {
                                                                    $posisi = 'Head';
                                                                } elseif ($u->id_posisi == 3) {
                                                                    $posisi = 'Head Chef';
                                                                } elseif ($u->id_posisi == 4) {
                                                                    $posisi = 'Head Server';
                                                                } elseif($u->id_posisi == 5) {
                                                                    $posisi = 'Server';
                                                                } else {
                                                                    $posisi = 'Presiden';
                                                                }
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $u->nama }}</td>
                                                                <td>{{ $u->username }}</td>
                                                                <td>{{ $posisi }}</td>
                                                                <td>Aktif</td>
                                                                <td>
                                                                    <a class="btn btn-success" href="#" data-toggle="modal" data-target="#edit{{$u->id}}">edit</a>
                                                                    <a href="#permission{{ $u->id }}"
                                                                        data-toggle="modal"
                                                                        class="btn btn-new permission"><i
                                                                            class="fas fa-key"></i></i></a><i
                                                                        style="color: rgb(176, 190, 197); --darkreader-inline-color:#a8a49e;"
                                                                        data-darkreader-inline-color="">
                                                                    </i>
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
                    <!-- /.card -->
                </div>
            </div>
        </div>

        <!-- Main content -->

        <!-- /.content -->
    </div>
   @foreach ($users as $u)
    <form action="{{ route('editUsers') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="edit{{$u->id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah Users</h5>

                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="id" value="{{$u->id}}">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="list_kategori">Nama</label>
                                    <input class="form-control" value="{{$u->nama}}" type="text" name="nama">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="list_kategori">Username</label>
                                    <input class="form-control" value="{{$u->username}}" type="text" name="username">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="list_kategori">Password</label>
                                    <input class="form-control" value="{{$u->password}}" type="password" name="password">
                                </div>
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
    @endforeach
    <form action="{{ route('addUsers') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Tambah Users</h5>

                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="jenis" value="{{ $jenis }}">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="list_kategori">Nama</label>
                                    <input class="form-control" type="text" name="nama">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="list_kategori">Username</label>
                                    <input class="form-control" type="text" name="username">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="list_kategori">Password</label>
                                    <input class="form-control" type="password" name="password">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="list_kategori">posisi</label>
                                    <select name="posisi" id="" class="form-control">
                                        @foreach ($tb_posisi as $i)
                                            <?php if($i->id_posisi == 3 || $i->id_posisi == 4 || $i->id_posisi == 6){ ?>
                                            <?php continue; ?>
                                            <?php } ?>
                                            <option value="{{ $i->id_posisi }}">{{ $i->nm_posisi }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
    @foreach ($users as $k)
        <form action="{{ route('permission') }}" method="post" accept-charset="utf-8">
            @csrf
            <div class="modal fade" id="permission{{ $k->id }}" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg-max" role="document">
                    <div class="modal-content ">
                        <div class="modal-header btn-costume">
                            @php
                                if ($jenis == 'tkm') {
                                    $j = 'Takemori';
                                } elseif ($jenis == 'adm') {
                                    $j = 'Administrator';
                                } elseif ($jenis == 'sdb') {
                                    $j = 'Soondobu';
                                }
                            @endphp
                            <h5 class="modal-title text-light" id="exampleModalLabel">Permission {{ $j }}</h5>
                            <a href="{{ route('importPermission', ['nama_user' => $k->nama]) }}"
                                class="btn btn-md btn-info ml-3" style="float :right"><i class="fas fa-file-excel"></i>
                                Export</a>
                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_user" value="{{ $k->id }}">
                            <div class="row">
                                @php
                                    $orderan = DB::table('tb_sub_navbar')
                                        ->where('jen', 1)
                                        ->where('id_navbar', 29)
                                        ->orderBy('urutan')
                                        ->get();
                                    $resto = DB::table('tb_sub_navbar')
                                        ->where('jen', 1)
                                        ->whereNotIn('id_navbar', [3, 5, 29])
                                        ->orderBy('urutan')
                                        ->get();
                                    $catatan = DB::table('tb_sub_navbar')
                                        ->where('id_navbar', 3)
                                        ->orderBy('urutan')
                                        ->get();
                                    $database = DB::table('tb_sub_navbar')
                                        ->where('id_navbar', 4)
                                        ->orderBy('urutan')
                                        ->get();
                                    $peringatan = DB::table('tb_sub_navbar')
                                        ->where('id_navbar', 5)
                                        ->orderBy('urutan')
                                        ->get();
                                    $permisi = DB::table('tb_permission')
                                        ->select('tb_permission.id_user')
                                        ->join('tb_sub_navbar', 'tb_permission.id_menu', '=', 'tb_sub_navbar.id_sub_navbar')
                                        ->join('users', 'tb_permission.id_user', '=', 'users.id')
                                        ->where('id_user', $k->id)
                                        ->orderBy('id_user')
                                        ->get();
                                @endphp
                                <?php if($jenis == 'adm') { ?>
                                <div id="adminMenu">
                                    <div id="permission">
                                        <h5>Administrator</h5>
                                        @foreach ($navbar as $n)
                                            @php
                                                $menu_id = DB::table('tb_permission')
                                                    ->select('id_menu')
                                                    ->where('id_user', $k->id)
                                                    ->where('id_menu', $n->id_sub_navbar)
                                                    ->where('lokasi', $jenis)
                                                    ->first();
                                                $no = 1;
                                                //  dd($menu_id);
                                            @endphp
                                            <div class="col-md-12">
                                                <input type="hidden" name="lokasi" value="{{ $jenis }}">
                                                {{-- <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                                value="{{ $p->id_menu }}" name="menu[]" id="check{{ $no }}"> --}}
                                                <div class="form-check ">
                                                    <input class="form-check-input" {{ $menu_id ? 'checked' : '' }}
                                                        type="checkbox" value="{{ $n->id_sub_navbar }}" name="menu[]"
                                                        id="check{{ $no }}">
                                                </div>
                                                <label class="form-check-label ml-3 mb-3" for="check{{ $no }}">
                                                    <b>{{ $n->sub_navbar }}</b>
                                                </label>
                                            </div>
                                            @php
                                                $no++;
                                            @endphp
                                            @php
                                                if ($n->sub_navbar == 'Gaji') {
                                                    break;
                                                }
                                            @endphp
                                        @endforeach
                                        <h5>Database</h5>
                                        <hr>
                                        @foreach ($database as $n)
                                            @php
                                                $menu_id = DB::table('tb_permission')
                                                    ->select('id_menu')
                                                    ->where('id_user', $k->id)
                                                    ->where('id_menu', $n->id_sub_navbar)
                                                    ->where('lokasi', $jenis)
                                                    ->first();
                                                $no = 1;
                                                //  dd($menu_id);
                                            @endphp
                                            <div class="col-md-12">
                                                <input type="hidden" name="lokasi" value="{{ $jenis }}">
                                                {{-- <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                                value="{{ $p->id_menu }}" name="menu[]" id="check{{ $no }}"> --}}
                                                <div class="form-check ">
                                                    <input class="form-check-input" {{ $menu_id ? 'checked' : '' }}
                                                        type="checkbox" value="{{ $n->id_sub_navbar }}" name="menu[]"
                                                        id="check{{ $no }}">
                                                </div>
                                                <label class="form-check-label ml-3 mb-3" for="check{{ $no }}">
                                                    <b>{{ $n->sub_navbar }}</b>
                                                </label>
                                            </div>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach

                                        <h5>Resto</h5>
                                        @foreach ($resto as $n)
                                            @php
                                                $menu_id = DB::table('tb_permission')
                                                    ->select('id_menu')
                                                    ->where('id_user', $k->id)
                                                    ->where('id_menu', $n->id_sub_navbar)
                                                    ->where('lokasi', $jenis)
                                                    ->first();
                                                $no = 1;
                                                //  dd($menu_id);
                                            @endphp
                                            <div class="col-md-12">
                                                <input type="hidden" name="lokasi" value="{{ $jenis }}">
                                                {{-- <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                                value="{{ $p->id_menu }}" name="menu[]" id="check{{ $no }}"> --}}
                                                <div class="form-check ">
                                                    <input class="form-check-input" {{ $menu_id ? 'checked' : '' }}
                                                        type="checkbox" value="{{ $n->id_sub_navbar }}" name="menu[]"
                                                        id="check{{ $no }}">
                                                </div>
                                                <label class="form-check-label ml-3 mb-3" for="check{{ $no }}">
                                                    <b>{{ $n->sub_navbar }}</b>
                                                </label>
                                            </div>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
                                        <h5>Orderan</h5>
                                        @foreach ($orderan as $n)
                                            @php
                                                $menu_id = DB::table('tb_permission')
                                                    ->select('id_menu')
                                                    ->where('id_user', $k->id)
                                                    ->where('id_menu', $n->id_sub_navbar)
                                                    ->where('lokasi', $jenis)
                                                    ->first();
                                                $no = 1;
                                                //  dd($menu_id);
                                            @endphp
                                            <div class="col-md-12">
                                                <input type="hidden" name="lokasi" value="{{ $jenis }}">
                                                {{-- <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                            value="{{ $p->id_menu }}" name="menu[]" id="check{{ $no }}"> --}}
                                                <div class="form-check ">
                                                    <input class="form-check-input" {{ $menu_id ? 'checked' : '' }}
                                                        type="checkbox" value="{{ $n->id_sub_navbar }}" name="menu[]"
                                                        id="check{{ $no }}">
                                                </div>
                                                <label class="form-check-label ml-3 mb-3" for="check{{ $no }}">
                                                    <b>{{ $n->sub_navbar }}</b>
                                                </label>
                                            </div>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
                                        <h5>Catatan</h5>

                                        @foreach ($catatan as $n)
                                            @php
                                                $menu_id = DB::table('tb_permission')
                                                    ->select('id_menu')
                                                    ->where('id_user', $k->id)
                                                    ->where('id_menu', $n->id_sub_navbar)
                                                    ->where('lokasi', $jenis)
                                                    ->first();
                                                $no = 1;
                                                //  dd($menu_id);
                                            @endphp
                                            <div class="col-md-12">
                                                <input type="hidden" name="lokasi" value="{{ $jenis }}">
                                                {{-- <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                                value="{{ $p->id_menu }}" name="menu[]" id="check{{ $no }}"> --}}
                                                <div class="form-check ">
                                                    <input class="form-check-input" {{ $menu_id ? 'checked' : '' }}
                                                        type="checkbox" value="{{ $n->id_sub_navbar }}" name="menu[]"
                                                        id="check{{ $no }}">
                                                </div>
                                                <label class="form-check-label ml-3 mb-3" for="check{{ $no }}">
                                                    <b>{{ $n->sub_navbar }}</b>
                                                </label>
                                            </div>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
                                        <h5>Peringatan</h5>
                                        <hr>
                                        @foreach ($peringatan as $n)
                                            @php
                                                $menu_id = DB::table('tb_permission')
                                                    ->select('id_menu')
                                                    ->where('id_user', $k->id)
                                                    ->where('id_menu', $n->id_sub_navbar)
                                                    ->where('lokasi', $jenis)
                                                    ->first();
                                                $no = 1;
                                                //  dd($menu_id);
                                            @endphp
                                            <div class="col-md-12">
                                                <input type="hidden" name="lokasi" value="{{ $jenis }}">
                                                {{-- <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                                value="{{ $p->id_menu }}" name="menu[]" id="check{{ $no }}"> --}}
                                                <div class="form-check ">
                                                    <input class="form-check-input" {{ $menu_id ? 'checked' : '' }}
                                                        type="checkbox" value="{{ $n->id_sub_navbar }}" name="menu[]"
                                                        id="check{{ $no }}">
                                                </div>
                                                <label class="form-check-label ml-3 mb-3" for="check{{ $no }}">
                                                    <b>{{ $n->sub_navbar }}</b>
                                                </label>
                                            </div>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                                <?php }else { ?>
                                <div id="restoMenu">
                                    <h5>Resto</h5>
                                    @foreach ($resto as $n)
                                        @php
                                            $menu_id = DB::table('tb_permission')
                                                ->select('id_menu')
                                                ->where('id_user', $k->id)
                                                ->where('id_menu', $n->id_sub_navbar)
                                                ->where('lokasi', $jenis)
                                                ->first();
                                            $no = 1;
                                            //  dd($menu_id);
                                        @endphp
                                        <div class="col-md-12">
                                            <input type="hidden" name="lokasi" value="{{ $jenis }}">
                                            {{-- <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                            value="{{ $p->id_menu }}" name="menu[]" id="check{{ $no }}"> --}}
                                            <div class="form-check ">
                                                <input class="form-check-input" {{ $menu_id ? 'checked' : '' }}
                                                    type="checkbox" value="{{ $n->id_sub_navbar }}" name="menu[]"
                                                    id="check{{ $no }}">
                                            </div>
                                            <label class="form-check-label ml-3 mb-3" for="check{{ $no }}">
                                                <b>{{ $n->sub_navbar }}</b>
                                            </label>
                                        </div>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach

                                    <h5>Orderan</h5>
                                    @foreach ($orderan as $n)
                                        @php
                                            $menu_id = DB::table('tb_permission')
                                                ->select('id_menu')
                                                ->where('id_user', $k->id)
                                                ->where('id_menu', $n->id_sub_navbar)
                                                ->where('lokasi', $jenis)
                                                ->first();
                                            $no = 1;
                                            //  dd($menu_id);
                                        @endphp
                                        <div class="col-md-12">
                                            <input type="hidden" name="lokasi" value="{{ $jenis }}">
                                            {{-- <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                            value="{{ $p->id_menu }}" name="menu[]" id="check{{ $no }}"> --}}
                                            <div class="form-check ">
                                                <input class="form-check-input" {{ $menu_id ? 'checked' : '' }}
                                                    type="checkbox" value="{{ $n->id_sub_navbar }}" name="menu[]"
                                                    id="check{{ $no }}">
                                            </div>
                                            <label class="form-check-label ml-3 mb-3" for="check{{ $no }}">
                                                <b>{{ $n->sub_navbar }}</b>
                                            </label>
                                        </div>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                    <h5>Catatan</h5>

                                    @foreach ($catatan as $n)
                                        @php
                                            $menu_id = DB::table('tb_permission')
                                                ->select('id_menu')
                                                ->where('id_user', $k->id)
                                                ->where('id_menu', $n->id_sub_navbar)
                                                ->where('lokasi', $jenis)
                                                ->first();
                                            $no = 1;
                                            //  dd($menu_id);
                                        @endphp
                                        <div class="col-md-12">
                                            <input type="hidden" name="lokasi" value="{{ $jenis }}">
                                            {{-- <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                            value="{{ $p->id_menu }}" name="menu[]" id="check{{ $no }}"> --}}
                                            <div class="form-check ">
                                                <input class="form-check-input" {{ $menu_id ? 'checked' : '' }}
                                                    type="checkbox" value="{{ $n->id_sub_navbar }}" name="menu[]"
                                                    id="check{{ $no }}">
                                            </div>
                                            <label class="form-check-label ml-3 mb-3" for="check{{ $no }}">
                                                <b>{{ $n->sub_navbar }}</b>
                                            </label>
                                        </div>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                    <h5>Peringatan</h5>
                                    <hr>
                                    @foreach ($peringatan as $n)
                                        @php
                                            $menu_id = DB::table('tb_permission')
                                                ->select('id_menu')
                                                ->where('id_user', $k->id)
                                                ->where('id_menu', $n->id_sub_navbar)
                                                ->where('lokasi', $jenis)
                                                ->first();
                                            $no = 1;
                                            //  dd($menu_id);
                                        @endphp
                                        <div class="col-md-12">
                                            <input type="hidden" name="lokasi" value="{{ $jenis }}">
                                            {{-- <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                            value="{{ $p->id_menu }}" name="menu[]" id="check{{ $no }}"> --}}
                                            <div class="form-check ">
                                                <input class="form-check-input" {{ $menu_id ? 'checked' : '' }}
                                                    type="checkbox" value="{{ $n->id_sub_navbar }}" name="menu[]"
                                                    id="check{{ $no }}">
                                            </div>
                                            <label class="form-check-label ml-3 mb-3" for="check{{ $no }}">
                                                <b>{{ $n->sub_navbar }}</b>
                                            </label>
                                        </div>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </div>
                                <?php } ?>

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
    {{-- ---------------- --}}
    {{-- form urutan permision --}}
    <form action="{{ route('editUrutan') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal fade" id="urutanPermission" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content ">
                    <div class="modal-header btn-costume">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Urutan Permission</h5>

                        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="jenis" value="{{ $jenis }}">
                            @php
                                $sub_navbar = DB::table('tb_sub_navbar')
                                    ->orderBy('urutan', 'asc')
                                    ->get();
                            @endphp
                            @foreach ($sub_navbar as $sb)
                                <div class="col-3">
                                    <div class="form-group">
                                        <input type="hidden" name="id_sub_navbar[]" value="{{ $sb->id_sub_navbar }}">
                                        <p for="list_kategori">{{ $sb->sub_navbar }}</p>
                                        <input class="form-control" type="number" name="urutan[]"
                                            value="{{ $sb->urutan }}">
                                    </div>
                                </div>
                            @endforeach
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
    {{-- --------------------- --}}
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
