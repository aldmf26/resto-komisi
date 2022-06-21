<table border="1" style="border-collapse:collapse;">
    <thead>
        <tr>
            <th colspan="3">Print kasbon TS : {{$dari}} ~ {{$sampai}}</th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1;
        // dd($kasbon);
        @endphp
        @foreach ($kasbon as $k)
            <tr>
                <td align="center">{{ $no++ }}</td>
                <td align="center">{{ $k->nm_karyawan }}</td>
                <td align="right">{{ number_format($k->totalNominal,0) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <th colspan="2">Total</th>
        <th>{{number_format($sum,0)}}</th>
    </tfoot>
    
</table>
<script>
    window.print()
</script>