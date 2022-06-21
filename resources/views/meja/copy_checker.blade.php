<!-- ======================================================== conten ======================================================= -->
<style>
    #background {
        position: absolute;
        z-index: 0;
        background: white;
        display: block;
        min-height: 50%;
        min-width: 50%;
        color: yellow;
    }

    #content {
        position: absolute;
        z-index: 1;
    }

    #bg-text {
        color: lightgrey;
        font-size: 120px;
        transform: rotate(300deg);
        -webkit-transform: rotate(300deg);
    }
</style>
<div id="background">
    <p id="bg-text">Copy</p>
</div>
<div style="font-size: 14px;" id="content">
    <table align="center" class="table" style="font-size: 14px;">
        <tbody>
            <tr>
                <td>
                    invoice #
                    {{$no_order}}<br>
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
                    {{date('h:i a', strtotime($d->j_mulai)) }}
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
    <hr>
    <input type="hidden" id="kode" value="{{$no_order }}">

</div>
<!-- ======================================================== conten ======================================================= -->
<script>
    window.print();
</script>