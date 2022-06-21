<style>
    th {
        position: sticky;
        top: 0;
        z-index: 998;
    }

    .scrl {
        overflow: auto;
    }

</style>
<a id="download" target="_blank" class="btn btn-sm btn-success mb-3" 
    href="{{ route('downloadAbsen', ['bulanDwn' => $bulan, 'tahunDwn' => $tahun_2]) }}">
    <i class="fa fa-download"></i> DOWNLOAD
</a>
<div class="card">
    <input type="hidden" id="nopage" value="">
    <table class="table table-md table-striped table-bordered" width="100%">
        <thead class="table-success">
            <tr>
                @php
                    $tgl = getdate();
                    
                    $bulan;
                    $tahun_2;
                    // $bulan = date('m');
                    // $tahun_2 = date('Y');
                    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun_2);
                    $total = $tanggal;
                @endphp
                <th style="white-space: nowrap;position: sticky;
                left: 0;
                z-index: 999;">NAMA</th>
                @for ($i = 1; $i <= $total; $i++)
                    <th class="text-center">{{ $i }}</th>
                @endfor
                <th>M</th>
                <th>E</th>
                <th>SP</th>
                <th>OFF</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                
            @endphp
            {{-- <div class="pagination">
                {{ $karyawan->links() }}
            </div> --}}
            @foreach ($karyawan as $d)
                @php
                    $totalOff = 0;
                    $totalM = 0;
                    $totalE = 0;
                    $totalSP = 0;
                @endphp
                <tr>
                    <td class="bg-dark" style="white-space: nowrap;position: sticky;
                    left: 0;
                    z-index: 999;">
                        <h5>{{ $d->nama }}</h5>
                    </td>
                    @for ($i = 1; $i <= $total; $i++)
                        @php
                            $data = DB::table('tb_absen')
                                ->select('tb_absen.*')
                                ->where('id_karyawan', '=', $d->id_karyawan)
                                ->whereDay('tgl', '=', $i)
                                ->whereMonth('tgl', '=', $bulan)
                                ->whereYear('tgl', '=', $tahun_2)
                                ->first();
                            
                        @endphp
                        <?php if($data) { ?>
                        <td class="text-center m">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            @if ($data->status == 'M')
                                <div class="dropdown">
                                    <button class="btnHapus btn btn-block btn-success" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        M
                                    </button>
                                    <ul class="dropdown-menu tutup" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a style="width:60px;" href="javascript:void(0)"
                                                class="btnUpdate btn text-center btn-warning mb-3" status="E"
                                                id_absen="{{ $data->id_absen }}" tahun="{{ $tahun_2 }}"
                                                bulan="{{ $bulan }}">E</a>
                                        </li>
                                        <li>
                                            <a style="width:60px;" class="btnUpdate btn text-center btn-primary"
                                                href="javascript:void(0)" status="SP" id_absen="{{ $data->id_absen }}"
                                                tahun="{{ $tahun_2 }}" bulan="{{ $bulan }}">SP</a>
                                        </li>
                                        <li>
                                            <a style="width:60px;" class="btnDelete btn text-center btn-info mt-3"
                                                href="javascript:void(0)" status="OFF"
                                                id_absen="{{ $data->id_absen }}" tahun="{{ $tahun_2 }}"
                                                bulan="{{ $bulan }}">OFF</a>
                                        </li>
                                    </ul>
                                </div>

                                @php
                                    $totalM++;
                                @endphp
                            @elseif($data->status == 'E')
                                <div class="dropdown">
                                    <button class="btnHapus btn btn-block btn-warning" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        E
                                    </button>
                                    <ul class="dropdown-menu tutup" aria-labelledby="dropdownMenuButton1">
                                        <li><a style="width:60px;" class="btnUpdate btn text-center btn-success mb-3"
                                                href="javascript:void(0)" status="M" id_absen="{{ $data->id_absen }}"
                                                tahun="{{ $tahun_2 }}" bulan="{{ $bulan }}">M</a>
                                        </li>
                                        <li><a style="width:60px;" class="btnUpdate btn text-center btn-primary"
                                                href="javascript:void(0)" status="SP"
                                                id_absen="{{ $data->id_absen }}" tahun="{{ $tahun_2 }}"
                                                bulan="{{ $bulan }}">SP</a>
                                        </li>
                                        <li>
                                            <a style="width:60px;" class="btnDelete btn text-center btn-info mt-3"
                                                href="javascript:void(0)" status="OFF"
                                                id_absen="{{ $data->id_absen }}" tahun="{{ $tahun_2 }}"
                                                bulan="{{ $bulan }}">OFF</a>
                                        </li>
                                    </ul>
                                </div>
                                @php
                                    $totalE++;
                                @endphp
                            @elseif($data->status == 'SP')
                                <div class="dropdown">
                                    <button href="javascript:void(0)" class="btnHapus btn btn-block btn-primary"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        SP
                                    </button>
                                    <ul class="dropdown-menu tutup" aria-labelledby="dropdownMenuButton1">
                                        <li><a style="width:60px;" class="btnUpdate btn text-center btn-warning mb-3"
                                                href="javascript:void(0)" status="E" id_absen="{{ $data->id_absen }}"
                                                tahun="{{ $tahun_2 }}" bulan="{{ $bulan }}">E</a>
                                        </li>
                                        <li><a style="width:60px;" class="btnUpdate btn text-center btn-success"
                                                href="javascript:void(0)" status="M" id_absen="{{ $data->id_absen }}"
                                                tahun="{{ $tahun_2 }}" bulan="{{ $bulan }}">M</a>
                                        </li>
                                        <li>
                                            <a style="width:60px;" class="btnDelete btn text-center btn-info mt-3"
                                                href="javascript:void(0)" status="OFF"
                                                id_absen="{{ $data->id_absen }}" tahun="{{ $tahun_2 }}"
                                                bulan="{{ $bulan }}">OFF</a>
                                        </li>
                                    </ul>
                                </div>
                                @php
                                    $totalSP++;
                                @endphp
                            @else
                            <a href="javascript:void(0)" class="btn btn-block  btn-info">
                                OFF
                            </a>
                            @php
                            $totalOff++;
                        @endphp
                         @endif
                        </td>
                        
                        
                   
                    <?php }else { ?>
                    <td class="bg-info m">
                        <a href="javascript:void(0)" id="input{{ $d->id_karyawan }}"
                            class="btnInput btn btn-block  btn-info" status="M" id_karyawan="{{ $d->id_karyawan }}"
                            page="3" tahun="{{ $tahun_2 }}" bulan="{{ $bulan }}"
                            tanggal="{{ $tahun_2 . '-' . $bulan . '-' . $i }}">
                            OFF
                        </a>
                    </td>
                    @php
                        $totalOff++;
                    @endphp
                    <?php } ?>
            @endfor
            <td class="bg-light">{{ $totalM }}</td>
            <td class="bg-light">{{ $totalE }}</td>
            <td class="bg-light">{{ $totalSP }}</td>
            <td class="bg-light">{{ $totalOff }}</td>

            </tr>
            @if ($d->id_karyawan == $d->id_karyawan)
                @php
                    continue;
                @endphp
            @else
                @php
                    break;
                @endphp
            @endif
            @endforeach

        </tbody>

    </table>
</div>
