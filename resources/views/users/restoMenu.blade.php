<h5>Resto</h5>
@foreach ($resto as $n)
    @php
        $menu_id = DB::table('tb_permission')
            ->select('id_menu')
            ->where('id_user', @$k->id)
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
            <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                value="{{ $n->id_sub_navbar }}" name="menu[]" id="check{{ $no }}">
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
            ->where('id_user', @$k->id)
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
            <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                value="{{ $n->id_sub_navbar }}" name="menu[]" id="check{{ $no }}">
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
            ->where('id_user', @$k->id)
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
            <input class="form-check-input" {{ $menu_id ? 'checked' : '' }} type="checkbox"
                value="{{ $n->id_sub_navbar }}" name="menu[]" id="check{{ $no }}">
        </div>
        <label class="form-check-label ml-3 mb-3" for="check{{ $no }}">
            <b>{{ $n->sub_navbar }}</b>
        </label>
    </div>
    @php
        $no++;
    @endphp
@endforeach
