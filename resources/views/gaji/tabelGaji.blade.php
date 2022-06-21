<div class="row">
    <div class="col-12">
        <div class="card mt-5">
            <div class="card-header">
                {{ $dari }} sampai {{ $sampai }}

                <a href="{{ route('gajiSum', ['dari' => $dari, 'sampai' => $sampai]) }}"
                    class="btn mr-2 btn-info btn-sm float-right"><i class="fas fa-file-export"></i>
                    Export</a>
            </div>

            <div class="card-body">
                <table class="table table-responsive" id="tableSum">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA KARYAWAN</th>
                            <th>TANGGAL MASUK</th>
                            <th>RP M</th>
                            <th>RP E</th>
                            <th>RP SP</th>
                            <th>BULANAN</th>
                            <th>TOTAL</th>
                            <th>TOTAL ANTAR</th>
                            <th>TOTAL TERIMA ORDER</th>
                            <th>POINT MASAK</th>
                            <th>NON POINT MASAK</th>
                            <th>CUCI/JAM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($gaji as $k)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $k->nama }}</td>
                                <td>{{ $k->tgl_masuk }}</td>
                                <td>{{ number_format($k->rp_m * $k->M) }}</td>
                                <td>{{ number_format($k->rp_e * $k->E) }}</td>
                                <td>{{ number_format($k->rp_sp * $k->Sp) }}</td>
                                <td>{{ $k->g_bulanan }}</td>
                                <td>{{ number_format($k->rp_m * $k->M + $k->rp_e * $k->E + $k->rp_sp * $k->Sp) }}
                                </td>
                                <td>{{ $k->ttl_pengantar == '' ? '0' : $k->ttl_pengantar }}</td>
                                <td>{{ $k->ttl_admin == '' ? '0' : $k->ttl_admin }}</td>
                                <td><?= $k->point_berhasil ? $k->point_berhasil : 0 ?></td>
                                <td><?= $k->point_gagal ? $k->point_gagal : 0 ?></td>
                                <td>{{ number_format($k->lama_cuci ? $k->lama_cuci / 60 : 0, 1) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
