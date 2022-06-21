<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachmen; filename=Data Denda.xls');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table class="table  " id="table" border="1">
    <thead>
                                    <tr>
                                        <th>No</th>
                                        
                                        <th>Nama</th>
                                        <th>Alasan</th>
                                        
                                        <th>Nominal</th>
                                        
                                        
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    <?php $i = 1;
                                    $total_s = 0;
                                    foreach ($denda as $d) :
                                        $total_s += $d->total
                                    ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            
                                            <td><?= $d->nama ?></td>
                                            <?php  $alasan = DB::table('tb_denda')->where('nama', $d->nama)->whereBetween('tgl', [$dari, $sampai])->get(); ?>
                                            <td>
                                                <?php foreach($alasan as $a): ?>
                                                 - <?= $a->alasan ?> <br>
                                                <?php endforeach ?>
                                                
                                            </td>
                                            <td><?= number_format($d->total,0) ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th><?= number_format($total_s,0) ?></th>
                                    </tr>
                                </tfoot>


                            </table>
</body>



</html>