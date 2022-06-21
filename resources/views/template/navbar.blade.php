<div class="subnavbar">
    <div class="subnavbar-inner">
        <div class="container text-center">
            <ul class="mainnav">
                @php
                    $navbar = DB::table('tb_navbar')->get();
                    $sub_navbar = DB::table('tb_sub_navbar')->get();
                    $id_user = Auth::user()->id;
                    $cek = DB::table('tb_permission')
                        ->join('tb_sub_navbar', 'tb_permission.id_menu', '=', 'tb_sub_navbar.id_navbar')
                        ->join('tb_navbar', 'tb_sub_navbar.id_navbar', '=', 'tb_navbar.id_navbar')
                        ->where('tb_permission.id_user', $id_user)
                        ->where('tb_sub_navbar.jen', 1)
                        ->orderBy('urutan')
                        ->get();
                    $cekadm = DB::table('tb_permission')
                        ->join('tb_sub_navbar', 'tb_permission.id_menu', '=', 'tb_sub_navbar.id_navbar')
                        ->join('tb_navbar', 'tb_sub_navbar.id_navbar', '=', 'tb_navbar.id_navbar')
                        ->where('tb_permission.id_user', $id_user)
                        ->where('tb_sub_navbar.jen', 2)
                        ->orderBy('urutan')
                        ->get();
                @endphp
                <?php if(Session::get('logout') == 'Adm'){ ?>
                @foreach ($cekadm as $c)
                    <?php if($c->jenis == 'navbar'){ ?>
                    <li>
                        <a href="{{ route($c->rot) }}"><img
                                src="{{ asset('assets') }}/img_menu/{{ $c->img }}"><span>{{ $c->sub_navbar }}</span>
                        </a>
                    </li>
                    <?php } ?>
                @endforeach
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <img
                            src="{{ asset('assets') }}/img_menu/server.png"><span>Database</span> <b
                            class="caret"></b></a>
                    <ul class="dropdown-menu">
                        @php
                            $sub_navbar = DB::table('tb_permission')
                                ->join('tb_sub_navbar', 'tb_permission.id_menu', '=', 'tb_sub_navbar.id_sub_navbar')
                                ->where('id_navbar', 4)
                                ->where('tb_permission.id_user', $id_user)
                                ->get();
                        @endphp
                        @foreach ($sub_navbar as $sn)
                            @php
                                if ($sn->id_sub_navbar == 11) {
                                    $get = '[]';
                                }
                            @endphp
                            <li><a
                                    href="{{ route($sn->rot) }}{{ $sn->id_sub_navbar == 11 ? '?id_lokasi=1' : '' }}{{ $sn->id_sub_navbar == 12 ? '?id_lokasi=2' : '' }}">{{ $sn->sub_navbar }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <?php }elseif(Session::get('logout') == 'Tkm' || Session::get('logout') == 'Sdb'){ ?>
                @foreach ($cek as $c)
                    <?php if($c->jenis == 'navbar'){ ?>
                    <li>
                        <a href="{{ route($c->rot) }}"><img
                                src="{{ asset('assets') }}/img_menu/{{ $c->img }}"><span>{{ $c->sub_navbar }}</span>
                        </a>
                    </li>
                    <?php if($c->rot == 'laporan'){ ?>
                    <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('assets') }}/img_menu/order2.png"><span>Orderan</span> <b
                                class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @php
                                $sub_navbar = DB::table('tb_permission')
                                    ->join('tb_sub_navbar', 'tb_permission.id_menu', '=', 'tb_sub_navbar.id_sub_navbar')
                                    ->where('id_navbar', 29)
                                    ->where('tb_permission.id_user', $id_user)
                                    ->get();
                            @endphp
                            @foreach ($sub_navbar as $sn)
                                <li><a href="{{ route($sn->rot) }}">{{ $sn->sub_navbar }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <?php } ?>
                    <?php } ?>
                @endforeach
                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('assets') }}/img_menu/notebook.png"><span>Catatan</span> <b
                            class="caret"></b></a>
                    <ul class="dropdown-menu">
                        @php
                            $sub_navbar = DB::table('tb_permission')
                                ->join('tb_sub_navbar', 'tb_permission.id_menu', '=', 'tb_sub_navbar.id_sub_navbar')
                                ->where('id_navbar', 3)
                                ->where('tb_permission.id_user', $id_user)
                                ->get();
                        @endphp
                        @foreach ($sub_navbar as $sn)
                            <li><a href="{{ route($sn->rot) }}">{{ $sn->sub_navbar }}</a></li>
                        @endforeach
                    </ul>
                </li>


                <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <img
                            src="https://upperclassindonesia.com/uploads/img_menu/warning-sign.png"><span>Peringatan</span>
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        @php
                            $sub_navbar = DB::table('tb_permission')
                                ->join('tb_sub_navbar', 'tb_permission.id_menu', '=', 'tb_sub_navbar.id_sub_navbar')
                                ->where('id_navbar', 5)
                                ->where('tb_permission.id_user', $id_user)
                                ->get();
                        @endphp
                        @foreach ($sub_navbar as $sn)
                            <li><a href="{{ route($sn->rot) }}">{{ $sn->sub_navbar }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <?php } ?>
            </ul>
        </div>
        <!-- /container -->
    </div>
    <!-- /subnavbar-inner -->
</div>
@section('script')
@endsection
