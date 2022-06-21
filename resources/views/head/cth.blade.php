<?php $menu = $this->db->query("SELECT b.nm_menu, c.nm_meja, a.* FROM tb_order AS a 
            LEFT JOIN view_menu AS b ON b.id_harga = a.id_harga
            LEFT JOIN tb_meja AS c ON c.id_meja = a.id_meja where a.id_lokasi = '$lokasi' and a.id_meja = '$m->id_meja' and aktif = '1'")->get(); ?>
<?php foreach ($menu as $m) : ?>
    <tr>
        <td></td>
        <td style="white-space:nowrap;text-transform: lowercase;"><?= $m->nm_menu ?></td>
        <td><?= $m->qty ?></td>
        <?php if ($m->selesai == 'dimasak') : ?>
            <?php if ($m->id_koki1 != '0') : ?>
                <td><a kode="<?= $m->id_order  ?>" class="btn btn-info btn-sm selesai"><i class="fas fa-thumbs-up"></i></a></td>
            <?php else : ?>
                <td><a kode="<?= $m->id_order  ?>" class="btn btn-info btn-sm gagal"><i class="fas fa-thumbs-up"></i></a></td>
            <?php endif ?>
        <?php else : ?>
        <?php endif ?>
    </tr>
<?php endforeach ?>