<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!------ Include the above in your HEAD tag ---------->

<style>
    body {
        background-color: #A2B3BB;
        color: #787878;
    }

</style>
<div class="container mt-5">

    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="card" style="background-color: #E7E9EF;">
                <div class="card-body p-0">
                    <div class="row p-5">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6 text-right" style="margin-top: -20px;">
                            <p class="font-weight-bold mb-1">checker #{{ $page->nm_meja }} {{ $dis->nm_distribusi }}
                            </p>
                            <p class="text-muted">TGL : <?= date('d-F-Y') ?></p>
                        </div>
                    </div>

                    <hr style="margin-top: -40px;">


                    @php
                        $ttl = 0;
                        $sub_total = 0;
                        foreach (Cart::content() as $c):
                            $ttl += $c->qty;
                            $sub_total += $c->qty * $c->price;
                        endforeach;
                    @endphp
                    <form action="{{ route('create') }}" id="form_save_percobaan" method="post">
                        @csrf
                        <div class="row p-5" style="margin-top: -40px;">
                            <div class="col-md-12">
                                <table class="table " style="font-weight: bold;">
                                    <thead>
                                        <tr>
                                            <th class="border-0 text-uppercase small font-weight-bold">Item
                                            </th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Jumlah</th>
                                            <th class="border-0 text-uppercase small font-weight-bold" width="30%">
                                                Harga/ Pcs</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $c)
                                            <tr>
                                                <td>
                                                    {{ $c->name }} <br>
                                                    * {{ $c->req }}
                                                </td>
                                                <td>
                                                    {{ $c->qty }}
                                                </td>
                                                <td>
                                                    Rp. {{ number_format($c->price, 0) }}
                                                </td>
                                            </tr>
                                            <input type="hidden" name="id_meja" value="{{ $page->id_meja }}">
                                            <input type="hidden" name="id_harga[]" value="{{ $c->id }} ">
                                            <input type="hidden" name="qty[]" value="{{ $c->qty }}">
                                            <input type="hidden" name="harga[]" value="{{ $c->price }}">
                                            <input type="hidden" name="req[]" value="{{ $c->options->req }}">
                                        @endforeach
                                        <tr>
                                            <td colspan="2">Subtotal</td>
                                            <td>Rp. {{ number_format($sub_total, 0) }}</td>
                                        </tr>
                                        <?php if ($dis->service == 'Y') : ?>
                                        @php
                                            $service = $sub_total * 0.07;
                                        @endphp
                                        <tr>
                                            <td colspan="2">Service Charge</td>
                                            <td>Rp. {{ number_format($service, 0) }}</td>
                                        </tr>
                                        <?php else : ?>
                                        @php
                                            $service = 0;
                                        @endphp
                                        <?php endif ?>
                                        <?php if ($dis->ongkir == 'Y') : ?>
                                        <?php if ($sub_total < $batas->rupiah) : ?>
                                        @php
                                            $ongkir = $onk->rupiah;
                                        @endphp
                                        <?php else : ?>
                                        @php
                                            $ongkir = 0;
                                        @endphp
                                        <?php endif ?>
                                        <tr>
                                            <td colspan="2">Ongkir</td>
                                            <td>Rp. {{ number_format($onk->rupiah, 0) }}</td>
                                        </tr>
                                        <?php else : ?>
                                        @php
                                            $ongkir = 0;
                                        @endphp
                                        <?php endif ?>

                                        <?php if ($dis->tax == 'Y') : ?>
                                        @php
                                            $tax = ($sub_total + $service + $ongkir) * 0.1;
                                        @endphp
                                        <tr>
                                            <td colspan="2">Tax</td>
                                            <td>Rp. {{ number_format($tax, 0) }}</td>
                                        </tr>
                                        <?php else : ?>
                                        @php
                                            $tax = 0;
                                        @endphp
                                        <?php endif; ?>


                                        @php
                                            $total2 = $sub_total + $service + $tax + $ongkir;
                                        @endphp

                                        <tr>
                                            @php
                                                $a = round($total2);
                                                $b = number_format(substr($a, -3), 0);
                                                
                                                if ($b == '000') {
                                                    $c = $a;
                                                    $round = '000';
                                                } elseif ($b < 1000) {
                                                    $c = $a - $b + 1000;
                                                    $round = 1000 - $b;
                                                }
                                            @endphp
                                            <td colspan="2">Total</td>
                                            <td>Rp. {{ number_format($c, 0) }}</td>
                                        </tr>

                                        <input type="hidden" name="ongkir" value="{{ $ongkir }}">
                                        <input type="hidden" name="orang" value="{{ $orang }}">
                                        <input type="hidden" name="id_distribusi" value="{{ $distribusi }}">
                                    </tbody>
                                </table>
                                <hr>

                                <center>
                                    <button type="submit" class="btn " id="save_btn"
                                        style="background-color: #363D4B;color:white">Submit</button>
                                    {{-- <button type="button" class="btn " id="tes"
                                        style="background-color: #363D4B;color:white">tes</button> --}}
                                    <a href="order" class="btn btn-danger"> Cancel</a>
                                </center>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $(document).on('submit', '#form_save_percobaan', function(event) {
            //   event.preventDefault();

            $('#save_btn').hide();
            // $('.save_loading').show();

        });
        $(document).on('click', '#tes', function() {
            //   event.preventDefault();

            alert('tes');
            // $('.save_loading').show();

        });
    });
</script>
