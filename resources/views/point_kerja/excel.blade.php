
<?php

header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachmen; filename=Point Kerja.xls');
?><!DOCTYPE html>
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
                                        <th>#</th>
                                        <th>Keterangan kerja</th>
                                        <th>Point / 1 jam</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach($tb_kerja as $t): ?>
                                    <tr>
                                        <td>
                                            <?= $i++ ?>
                                        </td>
                                        <td>
                                            <?= $t->ket ?>
                                        </td>
                                        <td>
                                            <?= $t->point ?>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>


                            </table>
</body>

<script>
    window.print()
</script>

</html>