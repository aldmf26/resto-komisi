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
            <th class="sticky-top th-atas">
                <?= $k->nama ?>
            </th>
            <?php endforeach ?>
            <th class="sticky-top th-atas">Time In</th>
        </tr>
    </thead>
    <tbody style="font-size: 18px;" id="tugas_head">
        <?php foreach ($menu_food as $m) : ?>
        <tr class="header">
            <td>
                <?= $m->nm_meja ?>
            </td>
            <td>
                <?= $m->nm_menu ?>
            </td>
            <td>
                <?= $m->request ?>
            </td>
            <td>
                <?= $m->qty ?>
            </td>
            <?php if ($m->id_koki1 != '0') : ?>
            <td><a kode="<?= $m->id_order ?>" class="btn btn-info btn-sm selesai"><i class="fas fa-thumbs-up"></i></a>
            </td>
            <?php else : ?>
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
            <?php if (date('H:i', strtotime($m->j_selesai)) < date('H:i', strtotime($m->j_mulai . '+40 minutes'))) : ?>
            <td><b style="color:blue;">
                    <?= date('H:i', strtotime($m->j_selesai)) ?>
                </b></td>
            <?php else : ?>
            <td><b style="color:red;">
                    <?= date('H:i', strtotime($m->j_selesai)) ?>
                </b></td>
            <?php endif ?>
        </tr>
        <?php endforeach ?>
        <tr class="header">
            <td class="bg-info">
            </td>
            <td class="bg-info" colspan="4" style="vertical-align: middle; text-align: center">
            </td>

            <?php foreach ($tb_koki as $k) : ?>
            <td class="bg-info" style="vertical-align: middle;">
                <?= $k->nama ?>
            </td>
            <?php endforeach ?>
            <td colspan="50" class="bg-info"></td>
        </tr>
        <?php foreach ($menu_food2 as $m) : ?>
        <tr>
            <td>
                <?= $m->nm_meja ?>
            </td>
            <td style="text-transform: lowercase;">
                <?= $m->nm_menu ?>
            </td>
            <td>
                <?= $m->request ?>
            </td>
            <td>
                <?= $m->qty ?>
            </td>
            <td><a kode="<?= $m->id_order ?>" class="btn btn-warning text-light btn-sm cancel"><i
                        class="fas fa-undo"></i></a>
            </td>
            <?php foreach ($tb_koki as $k) : ?>
            <?php if($k->id_karyawan == $m->id_koki1 || $k->id_karyawan == $m->id_koki2 || $k->id_karyawan == $m->id_koki3): ?>
            <td><i class="text-success fas fa-check-circle"></i></td>
            <?php else: ?>
            <td></td>
            <?php endif; ?>
            <?php endforeach ?>
            <?php if (date('H:i', strtotime($m->j_selesai)) < date('H:i', strtotime($m->j_mulai . '+40 minutes'))) : ?>
            <td><b style="color:blue;">
                    <?= date('H:i', strtotime($m->j_selesai)) ?>
                </b></td>
            <?php else : ?>
            <td><b style="color:red;">
                    <?= date('H:i', strtotime($m->j_selesai)) ?>
                </b></td>
            <?php endif ?>
        </tr>
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