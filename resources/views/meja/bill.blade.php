<!-- ======================================================== conten ======================================================= -->
<div style="font-size: 14px;">
    <table align="center" class="table" style="font-size: 14px;">
        <tbody>
            <tr>
                <td>
                    invoice <b>#
                        {{substr($no_order, 5)}}
                    </b><br>
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
                    {{$pesan_2->sum_qty }}
                </th>
                <th>NAMA MENU :
                    {{$pesan_2->sum_qty }}
                </th>
                <th>HARGA</th>
            </tr>
        </thead>
        <tbody>
            <?php $bayar = 0;
            foreach ($order  as $d) :
                $bayar += $d->harga * $d->qty;
                $dis = $d->id_distribusi
            ?>

            <tr>
                <td align="center">
                    {{$d->qty}}
                </td>
                <td>
                    {{$d->nm_menu}}
                </td>
                <td align="center">
                    {{number_format(($d->harga * $d->qty), 0)}}
                </td>
            </tr>
            <?php $ongkir = $d->ongkir ?>
            <?php endforeach ?>
        </tbody>
        @php
        $tb_dis = DB::table('tb_distribusi')
        ->where('id_distribusi', $dis)
        ->first();
        @endphp
        <?php if ($tb_dis->ongkir == 'Y') : ?>

        <?php if ($bayar < $batas->rupiah) : ?>
        <?php $ongkir = $ongkir2->rupiah ?>
        <?php else : ?>
        <?php $ongkir = 0 ?>
        <?php endif ?>
        <?php else : ?>
        <?php $ongkir = 0 ?>
        <?php endif ?>

        <?php if ($tb_dis->service == 'Y') : ?>
        <?php $service = $bayar * 0.07;  ?>

        <?php else : ?>
        <?php $service = 0  ?>
        <?php endif ?>

        <?php if ($tb_dis->tax == 'Y') {
            $tax = ($bayar + $service + $ongkir) * 0.1;
        } else {
            $tax = 0;
        } ?>


        <?php $total = $bayar + $service + $tax + $ongkir; ?>

        <tfoot>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>subtotal</td>
                <td></td>
                <td>
                    {{number_format($bayar)}}
                </td>
            </tr>
            <?php if ($tb_dis->ongkir == 'Y') : ?>
            <tr>
                <td>ongkir</td>
                <td></td>
                <td>
                    {{number_format($ongkir, 0) }}
                </td>
            </tr>
            <?php else : ?>
            <?php endif ?>
            <tr>
                <td>discount</td>
                <td> </td>
                <td>0</td>
            </tr>
            <?php if ($tb_dis->service == 'Y') : ?>
            <tr>
                <td>service charge</td>
                <td></td>
                <td>
                    {{number_format($service)}}
                </td>
            </tr>
            <?php else : ?>
            <?php endif ?>


            <tr>
                <td>tax</td>
                <td> </td>
                <td>
                    {{number_format($tax)}}
                </td>
            </tr>


            <tr style="font-weight: bold; font-style: italic;">
                <?php
                $a = round($total);
                $b = number_format(substr($a, -3), 0);

                if ($b == '000') {
                    $c = $a;
                    $round = '000';
                } elseif ($b < 1000) {
                    $c = $a - $b + 1000;
                    $round = 1000 - $b;
                }
                ?>
                <td>TOTAL</td>
                <td></td>
                <td>
                    {{number_format($c, 0)}}
                </td>
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