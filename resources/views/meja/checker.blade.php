<!-- ======================================================== conten ======================================================= -->
<?php if(empty($pesan_2)): ?>

<?php else : ?>
<div style="font-size: 14px;">
    <table align="center" class="table" style="font-size: 14px;">
        <tbody>
            <tr>
                <td>
                    invoice #
                    <?= $no_order; ?><br>
                    Server :
                    {{Session::get('id_lokasi') == 1 ? 'TAKEMORI' : 'SOONDOBU'}}
                </td>
                <td>
                    <?php
                    $Weddingdate = new DateTime($pesan_2->j_mulai);
                    echo $Weddingdate->format("M j, h:i:s a");
                    ?>
                    <br>
                </td>
                <td>
                    {{$pesan_2->nm_meja }}
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table class="table" align="center" style="font-size: 14px;">
        <thead style="font-family: Footlight MT Light;">
            <tr>
                <th colspan="3" style="text-align: left">FOOD</th>
            </tr>
            <tr>

                <th>QTY :
                    {{$pesan_2->sum_qty}}
                </th>
                <th>NAMA MENU :
                    {{$pesan_2->sum_qty}}
                </th>
                <th>Time: </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order  as $d) : ?>
            <tr>
                <td align="center">
                    {{$d->qty}}
                </td>
                <td>
                    {{$d->nm_menu}} <br> ***
                    {{$d->request}}
                </td>
                <td>
                    {{date('h:i a', strtotime($d->j_mulai))}}
                </td>
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

    <input type="hidden" id="kode" value="{{ $no_order }}">

</div>


<br>
<br>
<hr style="border: 1px solid black; ">
<br>
<br>
<?php endif ?>
<?php if(empty($pesan_3)): ?>
<?php else : ?>
<div style="font-size: 14px;">
    <hr>
    <table align="center" class="table" style="font-size: 14px;">
        <tbody>
            <tr>
                <td>
                    invoice #
                    <?= $no_order; ?><br>
                    Server :
                    {{Session::get('id_lokasi') == 1 ? 'TAKEMORI' : 'SOONDOBU'}}
                </td>
                <td>
                    <?php
                    $Weddingdate = new DateTime($pesan_3->j_mulai);
                    echo $Weddingdate->format("M j, h:i:s a");
                    ?>
                    <br>
                </td>
                <td>
                    {{$pesan_3->nm_meja }}
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table class="table" align="center" style="font-size: 14px;">
        <thead style="font-family: Footlight MT Light;">
            <tr>
                <th colspan="3" style="text-align: left">DRINK</th>
            </tr>
            <tr>
                <th>QTY :
                    {{$pesan_3->sum_qty}}
                </th>
                <th>NAMA MENU :
                    {{$pesan_3->sum_qty}}
                </th>
                <th>Time: </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order2  as $d) : ?>
            <tr>
                <td align="center">
                    {{$d->qty}}
                </td>
                <td>
                    {{$d->nm_menu}} <br> ***
                    {{$d->request}}
                </td>
                <td>
                    {{date('h:i a', strtotime($d->j_mulai))}}
                </td>
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

    <input type="hidden" id="kode" value="{{ $no_order }}">

</div>
<?php endif ?>
<!-- ======================================================== conten ======================================================= -->
<script>
    window.print();
</script>