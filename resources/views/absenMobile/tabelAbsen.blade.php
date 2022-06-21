<table class="table" id="tb_absen">

    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>M</th>
            <th>E</th>
            <th>SP </th>
            <th>OFF </th>
        </tr>
    </thead>
    <input type="hidden" value="<?= $tgl ?>" id="tgl">
    <tbody>
        <?php $i = 1;
        foreach ($tb_karyawan as $t) : ?>

        <?php
        
        $absen = DB::table('tb_absen')
            ->where('id_karyawan', $t->id_karyawan)
            ->where('tgl', $tgl)
            ->first();
        ?>
        <tr>
            <?php if (empty($absen)) : ?>
            <td><?= $i++ ?></td>
            <td>
                <?= $t->nama ?>
            </td>
            <td>
                <a href="javascript:void(0)" class="btn save btn-secondary" ket="M"
                    id_karyawan="<?= $t->id_karyawan ?>">M</a>
            </td>
            <td>
                <a href="javascript:void(0)" class="btn save btn-secondary" ket="E"
                    id_karyawan="<?= $t->id_karyawan ?>">E</a>
            </td>
            <td>
                <a href="javascript:void(0)" class="btn save btn-secondary" ket="SP"
                    id_karyawan="<?= $t->id_karyawan ?>">SP</a>
            </td>
            <td>
                <a href="javascript:void(0)" class="btn save btn-secondary" ket="OFF"
                    id_karyawan="<?= $t->id_karyawan ?>">OFF</a>
            </td>
            <?php else : ?>
            <td><?= $i++ ?>
            </td>
            <td><?= $t->nama ?></td>
            <td>
                <?php if ($absen->status == 'M') : ?>
                <a href="javascript:void(0)" class="btn btn-info btn-del" id_absen="<?= $absen->id_absen ?>">M</a>
                <?php else : ?>
                <a href="javascript:void(0)" id_absen_edit="<?= $absen->id_absen ?>" ket2="M"
                    class="btn btn-secondary btn-edit">M</a>
                <?php endif ?>
            </td>
            <td>
                <?php if ($absen->status == 'E') : ?>
                <a href="javascript:void(0)" class="btn btn-del btn-info" id_absen="<?= $absen->id_absen ?>">E</a>
                <?php else : ?>
                <a id_absen_edit="<?= $absen->id_absen ?>" ket2="E" class="btn btn-secondary btn-edit">E</a>
                <?php endif ?>
            </td>
            <td>
                <?php if ($absen->status == 'SP') : ?>
                <a href="javascript:void(0)" class="btn btn-del btn-info" id_absen="<?= $absen->id_absen ?>">SP</a>
                <?php else : ?>
                <a href="javascript:void(0)" id_absen_edit="<?= $absen->id_absen ?>" ket2="SP"
                    class="btn btn-secondary btn-edit">SP</a>
                <?php endif ?>
            </td>
            <td>
                <?php if ($absen->status == 'OFF') : ?>
                <a href="javascript:void(0)" class="btn btn-del btn-info" id_absen="<?= $absen->id_absen ?>">OFF</a>
                <?php else : ?>
                <a href="javascript:void(0)" id_absen_edit="<?= $absen->id_absen ?>" ket2="OFF"
                    class="btn btn-secondary btn-edit">OFF</a>
                <?php endif ?>
            </td>
            <?php endif ?>
        </tr>
        <?php endforeach ?>
    </tbody>

</table>

@section('script')
    <script>
        $("#tb_absen").DataTable({
            "lengthChange": false,
            "autoWidth": false,
            "stateSave": true,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    </script>
@endsection
