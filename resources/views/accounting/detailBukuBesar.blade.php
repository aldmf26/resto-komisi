@extends('accounting.template.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                   
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    @php
                              $dari = Request::get('dari') == '' ? date('Y-m-1') : Request::get('dari');
                              $sampai = Request::get('sampai') == '' ? date('Y-m-d') : Request::get('sampai');

                              $tDebit = DB::table('tb_jurnal')->where([['id_lokasi', Request::get('acc')],['id_buku',1]])->whereBetween('tgl', [$dari,$sampai])->sum('debit');
                            $tKredit = DB::table('tb_jurnal')->where([['id_lokasi', Request::get('acc')],['id_buku',1]])->whereBetween('tgl', [$dari,$sampai])->sum('kredit');
                          @endphp
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-left">Detail Buku Besar {{ date('d F Y', strtotime($dari)); }} ~ {{ date('d F Y', strtotime($sampai)); }}</h5>
                                <a href="" data-toggle="modal" data-target="#export"
                                    class="btn btn-info btn-sm float-right mr-1"><i class="fas fa-file-export"></i> Export
                                </a>
                                <a target="blank" href="{{ route('printBukuBesar', ['acc' => Request::get('acc'), 'dari' => $dari, 'sampai' => $sampai]) }}"
                                    class="btn btn-info btn-sm float-right mr-1"><i class="fas fa-file-export"></i>
                                    Print</a>
                            </div>
                            <div class="card-body">
                                @php
                                    $total_debit = 0;
                                    $total_kredit = 0;
                                    $total_saldo = 0;
                                    $saldo1 = 0;
                                @endphp
                                @foreach ($buku as $b)
                                    @php
                                    $saldo = $b->debit - $b->kredit;
                                    $saldo1 += $saldo;
                                    $total_debit += $b->debit;
                                    $total_kredit += $b->kredit;
                                    @endphp
                                @endforeach
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama Akun : </th>
                                            <th width="40%">{{ $akun->nm_akun }}</th>
                                            <th width="20%">No Akun : </th>
                                            <th>{{ $akun->no_akun }}</th>
                                        </tr>
                                    </thead>                           
                                </table>
                                <br><br>
                                <table class="table table-striped dataTable no-footer" id="table" role="grid"
                                aria-describedby="table_info">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>No Nota</th>
                                            <th>Tanggal</th>
                                            <th>Post Center</th>
                                            <th>Keterangan</th>
                                            <th>Post Akun2</th>
                                            <th>Keterangan2</th>
                                            <th>Debit <br>({{number_format($total_debit, 0)}})</th>
                                            <th>Kredit <br>({{number_format($total_kredit, 0)}})</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    @php
                                        if(empty($neraca)) {
                                            $debit_saldo = 0; 
                                            $kredit_saldo = 0;
                                        } else {
                                            $debit_saldo = $neraca->debit_saldo; 
                                            $kredit_saldo = $neraca->kredit_saldo;
                                        }
                                    @endphp
                                    <tbody>
                                        <?php 
                                            $total_debit = 0;
                                            $total_kredit = 0;
                                            $total_saldo = 0;
                                            $saldo1 = 0;
                                            $no = 1;
                                        ?>
                                        @foreach ($buku as $b)
                                        <?php

                                            $saldo = $b->debit - $b->kredit;
                                            $saldo1 += $saldo;
                                            $total_debit += $b->debit;
                                            $total_kredit += $b->kredit;
                                            // $total_saldo += $saldo;
                                        ?>
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td style="white-space: nowrap;">{{ $b->no_nota }}</td>
                                                <td>{{ date('d/m/Y', strtotime($b->tgl)) }}</td>
                                                <td>{{ $b->nm_post }}</td>
                                                <td><?= $b->ket ?></td>
                                                <td><?= $b->ket3 ?></td>
                                                <td><?= $b->ket2 ?></td>
                                                <td style="text-align: right;"><?= number_format($b->debit, 0) ?></td>
                                                <td style="text-align: right;"><?= number_format($b->kredit, 0) ?></td>
                                                <td><?= number_format($saldo1, 0) ?></td>
                                            </tr>
                                        @endforeach        
                                        @if (empty($neraca))
                                        @else
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($neraca->tgl)) ?></td>
                                            <td></td>
                                            <td style="white-space: nowrap;">Neraca saldo awal</td>
                                            <td style="text-align: right;"><?= number_format($neraca->debit_saldo, 0) ?></td>
                                            <td style="text-align: right;"><?= number_format($neraca->kredit_saldo, 0) ?></td>
                                            <td style="text-align: right;"><?= number_format($saldo1 + ($debit_saldo + $kredit_saldo), 0) ?></td>
                                        </tr>
                                        @endif                          
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <td colspan="7">Total</td>
                                            <td align="right">{{ number_format($total_debit + $debit_saldo, 0) }}</td>
                                            <td align="right">{{ number_format($total_kredit + $kredit_saldo, 0) }}</td>
                                            <td align="right">{{ number_format($saldo1 + ($debit_saldo + $kredit_saldo), 0) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <style>
        .modal-lg-max {
            max-width: 1000px;
        }

    </style>
    {{-- view tanggal --}}
    <form action="{{ route('bukuBesar', ['acc' => Request::get('acc')]) }}" method="get">
        <div class="modal fade" id="viewtgl" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md-6" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Pertanggal</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                          <input type="hidden" name="acc" value="{{Request::get('acc')}}">
                            <div class="col-md-6">
                                <label for="">Dari</label>
                                <input required type="date" name="dari" class="form-control mb-3">
                            </div>
                            <div class="col-md-6">
                                <label for="">Sampai</label>
                                <input required type="date" name="sampai" class="form-control mb-3">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="simpan" value="Simpan" id="tombol"
                                class="btn btn-primary mt-3">
                            <button type="button" class="btn btn-secondary  mt-3"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </form>
      {{-- --------------------------- --}}

      {{-- export tanggal --}}
    <form action="{{ route('exportBukuBesar', ['acc' => Request::get('acc')]) }}" method="get">
        <div class="modal fade" id="export" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md-6" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Pertanggal</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                          <input type="hidden" name="acc" value="{{Request::get('acc')}}">
                            <div class="col-md-6">
                                <label for="">Dari</label>
                                <input required type="date" name="dari" class="form-control mb-3">
                            </div>
                            <div class="col-md-6">
                                <label for="">Sampai</label>
                                <input required type="date" name="sampai" class="form-control mb-3">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="simpan" value="Simpan" id="tombol"
                                class="btn btn-primary mt-3">
                            <button type="button" class="btn btn-secondary  mt-3"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </form>
      {{-- --------------------------- --}}

    


    

  {{-- end export pertanggal --}}
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
@endsection
@section('script')
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
@endsection