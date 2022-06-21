<?php $jumlah = 0;
foreach ($distribusi as $d) : $jumlah += $d->jumlah ?>

<?php endforeach ?>
<input type="hidden" id="jumlah" value="<?= $jumlah ?>">