<!-- ======================================================== conten ======================================================= -->
<div style="font-size: 14px;">
    <table align="center" class="table" style="font-size: 14px;">
        <tbody>
            <tr>
                <td>
                    invoice #<?= $no_order ?><br>
                    Server : {{ Session::get('id_lokasi') == 1 ? 'Takemori' : 'Soondobu' }}

                </td>
                <td>
                    <?php
                    $Weddingdate = new DateTime($pesan_2[0]->j_mulai);
                    echo $Weddingdate->format('M j, h:i:s a');
                    ?>
                    <br>
                </td>
                <td><?= $pesan_2[0]->nm_meja ?></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table class="table" align="center" style="font-size: 14px;">
        <thead style="font-family: Footlight MT Light;">
            <tr>
                <th>QTY : <?= $pesan_2[0]->sum_qty ?></th>
                <th>NAMA MENU : <?= $pesan_2[0]->sum_qty ?></th>
                <th>Time: </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order  as $d) : ?>
            <tr>
                <td align="center"><?= $d->qty ?></td>
                <td><?= $d->nm_menu ?> <br> ***<?= $d->request ?></td>
                <td><?= date('h:i a', strtotime($d->j_mulai)) ?></td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
    <hr>
    <?php echo ''; ?>
</div>
<!-- ======================================================== conten ======================================================= -->
<script>
    window.print();
</script>
