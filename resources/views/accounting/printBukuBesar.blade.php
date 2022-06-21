<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
      
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
      
        <script>
          window.print();
        </script>
        <title>Print Buku Besar</title>
      </head>
<body>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <h2 class="text-center">Print Buku Besar : {{ Request::get('dari') }} ~ {{ Request::get('sampai') }} </h2>
            <br><br><br>
            <div class="card">
                @php
                                    $no = 1;
                                    $total_debit = 0;
                                    $total_kredit = 0;
                                    $total_saldo = 0;
                                    $laba_ditahan = 0;
                                @endphp
                                @foreach ($buku as $b)
                                    @php
                                        $saldo = $b->debit + $b->debit_saldo  - $b->kredit - $b->kredit_saldo;
                                        $debit = $b->debit + $b->debit_saldo;
                                        $kredit = $b->kredit + $b->kredit_saldo;
                                        $total_debit += $debit;
                                        $total_kredit += $kredit;
                                        $total_saldo += $saldo; 
                                        if ($debit == 0 and $kredit == 0) {
                                            continue;
                                        }
                                    @endphp
                                @endforeach
                <div class="card-body">
                    <table class="table" id="table">
                        <tr>
                            <th>No Akun</th>
                            <th>Nama Post Akun</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Saldo</th>
                        </tr>
                        <tbody>
                            @php
                                $total_debit = 0;
                                $total_kredit = 0;
                                $total_saldo = 0;
                                $laba_ditahan = 0;
                            @endphp
                            @foreach ($buku as $b)
                                @php
                                    $saldo = $b->debit + $b->debit_saldo  - $b->kredit - $b->kredit_saldo;
                                    $debit = $b->debit + $b->debit_saldo;
                                    $kredit = $b->kredit + $b->kredit_saldo;
                                    $total_debit += $debit;
                                    $total_kredit += $kredit;
                                    $total_saldo += $saldo;
                                    if ($debit == 0 and $kredit == 0) {
                                    continue;
                                    }
                                @endphp
                            <tr>
                                <td>{{ $b->no_akun }}</td>
                                <td>{{ $b->nm_akun }}</td>
                                <td>{{ number_format($debit, 0) }}</td>
                                <td>{{ number_format($kredit, 0) }}</td>
                                <td>{{ number_format($saldo, 0) }}</td>
                            </tr>
                            @endforeach
                            <tr style="background-color: #00B7B5;">
                                <td style="color : white;" colspan="2">Total</td>
                                <td style="color : white;">{{ number_format($total_debit,0) }}</td>
                                <td style="color : white;">{{ number_format($total_kredit,0) }}</td>
                                <td style="color : white;">{{ number_format($total_saldo,0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>  
    </div>
</body>
</html>
<script>
    $('#table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
</script>