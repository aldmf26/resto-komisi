<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=Data Gaji Resto.xls');
?>
<div class="row">
    <div class="col-12">
        <div class="card mt-5">
            <center>
                <h2 style="margin-right: 300px">Gaji Karyawan</h2>
            </center>
            <div class="card-header">
                <h3 style="margin-left: 50px">Dari {{ $dari }} Sampai {{ $sampai }}</h3>
            </div>

            <div class="card-body">
                <table border="1">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tgl Masuk</th>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Posisi</th>
                            <th>Absen OFF</th>
                            <th>Absen M</th>
                            <th>Absen E</th>
                            <th>Absen SP</th>
                            <th>Total Antar</th>
                            <th>TOTAL TERIMA ORDER</th>
                            <th>RP M</th>
                            <th>RP E</th>
                            <th>RP SP</th>
                            <th>Bulanan</th>
                            <th>Point Masak</th>
                            <th>Non Point Masak</th>
                            <th>Kerja lain-lain / Ttl Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                            $total = 0;
                            $total_gagal = 0;
                            $total_berhasil = 0;
                            $total_cuci = 0;
                        @endphp
                        @foreach ($gaji as $k)
                            @php
                                
                                $total += $k->rp_m * $k->M + $k->rp_e * $k->E + $k->rp_sp * $k->Sp + $k->g_bulanan;
                                $total_cuci += $k->lama_cuci ? $k->lama_cuci / 60 : 0;
                                
                            @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $k->nama }}</td>
                                <td>{{ $k->tgl_masuk }}</td>
                                @php
                                    $totalKerja = new DateTime($k->tgl_masuk);
                                    $today = new DateTime();
                                    $tKerja = $today->diff($totalKerja);
                                @endphp
                                <td>{{ $tKerja->y }}</td>
                                <td>{{ $tKerja->m }}</td>
                                <td>{{ $k->nm_posisi }}</td>
                                <td>{{ $k->of }}</td>
                                <td>{{ $k->M }}</td>
                                <td>{{ $k->E }}</td>
                                <td>{{ $k->Sp }}</td>
                                <td>{{ $k->ttl_pengantar == '' ? '0' : $k->ttl_pengantar }}</td>
                                <td>{{ $k->ttl_admin == '' ? '0' : $k->ttl_admin }}</td>
                                <td>{{ number_format($k->rp_m, 0) }}</td>
                                <td>{{ number_format($k->rp_e, 0) }}</td>
                                <td>{{ number_format($k->rp_sp, 0) }}</td>
                                <td>{{ number_format($k->g_bulanan, 0) }}</td>
                                <td>{{ number_format($k->point_berhasil ? $k->point_berhasil : 0,1) }}</td>
                                <td>{{ number_format($k->point_gagal ? $k->point_gagal : 0,1) }}</td>
                                <td>{{ number_format($k->lama_cuci ? $k->lama_cuci / 60 : 0, 1) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="12" align="center">TOTAL</th>
                            <th>{{ number_format($total) }}</th>
                            <th><?= number_format($total_berhasil, 1) ?></th>
                            <th><?= number_format($total_gagal, 1) ?></th>
                            <th><?= number_format($total_cuci, 1) ?></th>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
