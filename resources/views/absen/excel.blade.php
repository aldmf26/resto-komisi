<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachmen; filename=Absensi Resto.xls');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('assets') }}/css/google-font.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap-icons.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- select 2 -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset('assets') }}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">
    <link rel="stylesheet" type="text/css" href=" {{ asset('assets') }}/css/slider.css">
    <link rel="stylesheet" type="text/css" href=" {{ asset('assets') }}/dropify/dist/css/dropify.min.css">
    <link href="{{ asset('assets') }}/plugins/bootstrap/css/bootstrap-switch-button.min.css" rel="stylesheet" />

    <link href="{{ asset('assets') }}/plugins/bootstrap/css/bootstrap4-toggle.min.css" rel="stylesheet">
</head>
<body>
    @php
        $bulan_2 = ['bulan', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulan1 = (int) $bulan;
    @endphp
    <h1>Tanggal : {{ $bulan_2[$bulan1] }} {{ $tahun }}</h1>
    <table align="left" border="1">
        <thead>
            <tr>
                @php
                    $tgl = getdate();
                    
                    $bulan;
                    $tahun;
                    // $bulan = date('m');
                    // $tahun = date('Y');
                    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
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
                                ->whereYear('tgl', '=', $tahun)
                                ->first();
                            
                        @endphp
                        <?php if($data) { ?>

                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            @if ($data->status == 'M')
                            <td align="center" style="color: green;">
                                M
                            </td>

                                @php
                                    $totalM++;
                                @endphp
                            @elseif($data->status == 'E')
                            <td align="center" style="color: rgb(119, 119, 110);">
                                E
                            </td>
                                @php
                                    $totalE++;
                                @endphp
                            @elseif($data->status == 'SP')
                            <td align="center" style="color: blue;">
                                SP
                            </td>
                                @php
                                    $totalSP++;
                                @endphp
                            @else
                            <td align="center" style="color: black;">
                                OFF
                            </td>
                            @php
                            $totalOff++;
                        @endphp
                         @endif
                        
                        
                   
                    <?php }else { ?>
                        <td align="center" style="color: black;">
                            OFF
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
</body>

</html>
