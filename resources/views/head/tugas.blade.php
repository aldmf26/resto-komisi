@php
    function timeDiff($firstTime,$lastTime)
{

// convert to unix timestamps
$firstTime=strtotime($firstTime);
$lastTime=strtotime($lastTime);

// perform subtraction to get the difference (in seconds) between times
$timeDiff=$lastTime-$firstTime;

// return the difference
return $timeDiff;
}
@endphp
<style>
    .table tr:not(.header) {
        display: none;
    }

</style>

<table class="table" width="100%">
    <thead>
        <tr class="header">
            <th class="sticky-top th-atas">Meja</th>
            <th class="sticky-top th-atas">Menu</th>
            <th class="sticky-top th-atas">Request</th>
            <th class="sticky-top th-atas">Qty</th>
            <th class="sticky-top th-atas">Status</th>
            <?php foreach ($tb_koki as $k) : ?>
            <th class="sticky-top th-atas"><?= $k->nama ?></th>
            <?php endforeach ?>
            <th class="sticky-top th-atas">Time In</th>
        </tr>
    </thead>
    <tbody style="font-size: 18px;" id="tugas_head">
        <?php foreach ($meja as $m) : ?>
        <tr class="header">
            <td class="bg-info"><?= $m->nm_meja ?></td>
            <td class="bg-info" style="vertical-align: middle;"><a class="muncul btn btn-primary btn-sm">View</a>
            </td>
            <td class="bg-info"></td>
            <td class="bg-info"></td>
            <td class="bg-info"></td>
            <?php foreach ($tb_koki as $k) : ?>
            <td class="bg-info" style="vertical-align: middle;"><?= $k->nama ?></td>
            <?php endforeach ?>
            <td colspan="50" class="bg-info"></td>
        </tr>
        <?php $menu = DB::select(
            "SELECT b.nm_menu, c.nm_meja, a.* FROM tb_order AS a LEFT JOIN view_menu AS b ON b.id_harga = a.id_harga
                                                                LEFT JOIN tb_meja AS c ON c.id_meja = a.id_meja where a.id_lokasi = '$lokasi' and a.id_meja = '$m->id_meja' and a.selesai = 'dimasak' and aktif = '1' and void = 0"
        ); ?>
        <?php $menu2 = DB::select(
            "SELECT b.nm_menu, c.nm_meja, a.*, TIMEDIFF('a.j_selesai', 'a.j_mulai') as menit FROM tb_order AS a 
                                                                LEFT JOIN view_menu AS b ON b.id_harga = a.id_harga
                                                                LEFT JOIN tb_meja AS c ON c.id_meja = a.id_meja where a.id_lokasi = '$lokasi' and a.id_meja = '$m->id_meja' and a.selesai != 'dimasak' and aktif = '1' and void = 0"
        ); ?>

        <?php foreach ($menu2 as $m) : ?>
        <tr>
            <td></td>
            <td style="text-transform: lowercase;"><?= $m->nm_menu ?></td>
            <td><?= $m->request ?></td>
            <td><?= $m->qty ?></td>
            <td><a kode="<?= $m->id_order ?>" class="btn btn-warning text-light btn-sm cancel"><i
                        class="fas fa-undo"></i></a></td>
            <?php foreach ($tb_koki as $k) : ?>
            <?php if($k->id_karyawan == $m->id_koki1 || $k->id_karyawan == $m->id_koki2 || $k->id_karyawan == $m->id_koki3): ?>
            <td><i class="text-success fas fa-check-circle"></i></td>
            <?php else: ?>
            <td></td>
            <?php endif; ?>
            <?php endforeach ?>
            <?php if (date('H:i', strtotime($m->j_selesai)) < date('H:i', strtotime($m->j_mulai . '+40 minutes'))) : ?>
            @php
                $mulai = Str::remove(':', date('H:i', strtotime($m->j_mulai)));
                $akhir = Str::remove(':', date('H:i', strtotime($m->j_selesai)));
                $menit = (int) $akhir - $mulai;
            @endphp
            <td><b style="color:blue;"><?= date('H:i', strtotime($m->j_selesai)) ?> / {{ $menit }} Menit</b></td>
            <?php else : ?>
            <td><b style="color:red;"><?= date('H:i', strtotime($m->j_selesai)) ?> </b></td>
            <?php endif ?>
        </tr>
        <?php endforeach ?>
        <?php foreach ($menu as $m) : ?>
        <tr class="header">
            <td></td>
            <td style="white-space:nowrap;text-transform: lowercase;"><?= $m->nm_menu ?></td>
            <td><?= $m->request ?></td>
            <td><?= $m->qty ?></td>
            <?php if ($m->selesai == 'dimasak') : ?>
            <?php if ($m->id_koki1 != '0') : ?>
            <td><a kode="<?= $m->id_order ?>" class="btn btn-info btn-sm selesai"><i class="fas fa-thumbs-up"></i></a>
            </td>
            <?php else : ?>
            <!-- <td><a kode="<?= $m->id_order ?>" class="btn btn-info btn-sm gagal"><i class="fas fa-thumbs-up"></i></a></td> -->
            <td></td>
            <?php endif ?>
            <?php foreach ($tb_koki as $k) : ?>
            <?php if ($m->id_koki1 != '0') : ?>
            <?php if ($m->id_koki1 == $k->id_karyawan) : ?>
            <td><a kode="<?= $m->id_order ?>" class="btn btn-warning btn-sm un_koki1"><i class="fas fa-minus"></i></a>
            </td>
            <?php else : ?>
            <?php if ($m->id_koki2 != '0') : ?>
            <?php if ($m->id_koki2 == $k->id_karyawan) : ?>
            <td><a kode="<?= $m->id_order ?>" class="btn btn-sm btn-warning un_koki2"><i
                        class="fas fa-grip-lines"></i></a></td>
            <?php else : ?>
            <?php if ($m->id_koki3 != '0') : ?>
            <td><a kode="<?= $m->id_order ?>" class="btn btn-sm btn-warning un_koki3"><i class="fas fa-bars"></i></a>
            </td>
            <?php else : ?>
            <td><a kode="<?= $m->id_order ?>" kry="<?= $k->id_karyawan ?>" class="btn btn-sm btn-success koki3"><i
                        class="fas fa-users"></i></a></td>
            <?php endif ?>
            <?php endif ?>

            <?php else : ?>
            <td><a kode="<?= $m->id_order ?>" kry="<?= $k->id_karyawan ?>" class="btn btn-sm btn-success koki2"><i
                        class="fas fa-user-friends"></i></a></td>
            <?php endif ?>
            <?php endif ?>
            <?php else : ?>
            <td><a kode="<?= $m->id_order ?>" kry="<?= $k->id_karyawan ?>" class="btn btn-sm btn-success koki1"><i
                        class="fas fa-check"></i></a></td>
            <?php endif ?>
            <?php endforeach ?>
            <td style="font-weight: bold;"><?= date('H:i', strtotime($m->j_mulai)) ?></td>
            <?php else : ?>
            <td style="text-decoration: line-through; "><a href="<?= base_url("orderan/order/$m->no_order") ?>"
                    style="color:black;">SELESAI</a></td>
            <?php foreach ($tb_koki as $k) : ?>
            <td></td>
            <?php endforeach ?>
            <?php if (date('H:i', strtotime($m->j_selesai)) < date('H:i', strtotime($m->j_mulai . '+40 minutes'))) : ?>
            <td><b style="color:blue;"><?= date('H:i', strtotime($m->j_selesai)) ?></b></td>
            <?php else : ?>
            <td><b style="color:red;"><?= date('H:i', strtotime($m->j_selesai)) ?></b></td>
            <?php endif ?>
            <?php endif ?>
        </tr>
        <?php endforeach ?>
        <?php endforeach ?>
    </tbody>
</table>


<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('assets') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
<!--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->


<script>
    $(document).ready(function() {
        var ua = navigator.userAgent,
            event = (ua.match(/iPad/i)) ? "touchstart" : "click";
        if ($('.table').length > 0) {
            $('.table .header').on(event, function() {
                $(this).toggleClass("active", "").nextUntil('.header').css('display', function(i, v) {
                    return this.style.display === 'table-row' ? 'none' : 'table-row';
                });
            });
        }
    })
</script>
