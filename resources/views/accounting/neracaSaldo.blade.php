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
                    <div class="col-lg-10">
                        @include('accounting.template.flash')
                        <div class="card">
                            <div class="card-header">
                                <form action="{{ route('addNeracaSaldo') }}">
                                    <h3 class="float-left">Neraca Saldo</h3>
                                    <button type="submit" class="btn btn-info float-right">Save Neraca Saldo</button>
                          
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input type="date" value="2020-01-01" name="tgl" class="form-control col-lg-3">
                                    <input type="hidden" name="id_lokasi" value="{{ Request::get('acc') }}">
                                    <table class="table mt-2">
                                        <thead>                                
                                            <tr class="table-info">
                                                <th width="50%" class="sticky-top th">Akun</th>
                                                <th width="25%" class="sticky-top th">Debit</th>
                                                <th width="30%" class="sticky-top th">Kredit</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $tgl = '';
                                            $total_debit = 0;
                                            $total_kredit = 0;
                                        ?>                
                                        <tbody>
                                            @foreach ($neracaSaldo as $a)     
                                            @php
                                                $total_debit += $a->debit_saldo;
                                                $total_kredit += $a->kredit_saldo;
                                            @endphp        
                                            <tr>
                                                <td>{{ $a->nm_akun }}</td>
                                                <input type="hidden" name="id_akun[]" value="{{ $a->id_akun }}">
                                                <td><input type="number" name="debit_saldo[]" value="<?= $a->debit_saldo ?>" min="0" class="form-control"></td>
                                                <td><input type="number" name="kredit_saldo[]" value="<?= $a->kredit_saldo ?>" min="0" class="form-control"></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th><?= number_format($total_debit, 0) ?></th>
                                                <th><?= number_format($total_kredit, 0) ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                                </div>
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
    {{-- add akun --}}


    


    

  {{-- end export pertanggal --}}
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
@endsection
@section('script')
    
@endsection