
<table class="table  " id="tableMenu">
    <thead>
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Kode Menu</th>
            <th>Nama Menu</th>
            <th>Tipe</th>
            <th>Distribusi</th>
            <th></th>
            <th>On/Off</th>
            <!--<th>Image</th>-->
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($menu as $m)
            @php
                $harga = DB::table('tb_harga')
                    ->select('tb_harga.*', 'tb_distribusi.*')
                    ->join('tb_distribusi', 'tb_harga.id_distribusi', '=', 'tb_distribusi.id_distribusi')
                    ->where('id_menu', $m->id_menu)
                    ->get();
            @endphp
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $m->kategori }}</td>
                <td>{{ $m->kd_menu }}</td>
                <td>{{ ucwords(Str::lower($m->nm_menu)) }}</td>
                <td>{{ $m->tipe }}</td>
                <td style="white-space: nowrap;">
                    @foreach ($harga as $h)
                        {{ $h->nm_distribusi }} <br>
                    @endforeach
                </td>
    
                <td>
                    @foreach ($harga as $h)
                        :{{ number_format($h->harga, 0) }} <br>
                    @endforeach
                    <a href="" data-toggle="modal"
                        data-target="#distribusi{{ $m->id_menu }}" class="btn btn-new"
                        style="background-color: #F7F7F7;"><i style="color: #B0BEC5;"><i
                                class="fas fa-plus"></i></a>
                </td>
                <td>
                    <label class="switch float-left">
                        <?php if ($m->aktif == 'on') : ?>
                        <input type="checkbox" class="form-checkbox1" id="form-checkbox"
                            id_checkbox="<?= $m->id_menu ?>" checked>
                        <span class="slider round"></span>
                        <?php else : ?>
                        <input type="checkbox" class="form-checkbox1"
                            id_checkbox="<?= $m->id_menu ?>" id="form-checkbox">
                        <span class="slider round"></span>
                        <?php endif ?>
    
                    </label>
                    <?php if ($m->aktif == 'on') : ?>
                    <input name="monitor"
                        class="swalDefaultSuccess form-password nilai<?= $m->id_menu ?>  form-control"
                        value="on" hidden>
                    <?php else : ?>
                    <input name="monitor"
                        class="swalDefaultSuccess form-password nilai<?= $m->id_menu ?>  form-control"
                        hidden>
                    <?php endif ?>
                </td>
                <td style="white-space: nowrap;">
                    <a href="" data-toggle="modal"
                        data-target="#edit_data{{ $m->id_menu }}"
                        id_menu="{{ $m->id_menu }}" class="btn edit_menu btn-new"
                        style="background-color: #F7F7F7;"><i style="color: #B0BEC5;"><i
                                class="fas fa-edit"></i></a>
                    <a onclick="return confirm('Apakah ingin hapus ?')"
                        href="{{ route('deleteMenu', ['id_menu' => $m->id_menu, 'id_lokasi' => $id_lokasi]) }}"
                        class="btn  btn-new" style="background-color: #F7F7F7;"><i
                            style="color: #B0BEC5;"><i class="fas fa-trash-alt"></i></a>
    
                </td>
            </tr>
        @endforeach
    </tbody>

</table>