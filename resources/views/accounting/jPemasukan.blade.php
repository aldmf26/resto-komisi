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
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                      @include('accounting.template.flash')
                        <div class="card">
                          @php
                              $dari = Request::get('dari') == '' ? date('Y-m-1') : Request::get('dari');
                              $sampai = Request::get('sampai') == '' ? date('Y-m-d') : Request::get('sampai');

                              $tDebit = DB::table('tb_jurnal')->where([['id_lokasi', Request::get('acc')],['id_buku',1]])->whereBetween('tgl', [$dari,$sampai])->sum('debit');
                            $tKredit = DB::table('tb_jurnal')->where([['id_lokasi', Request::get('acc')],['id_buku',1]])->whereBetween('tgl', [$dari,$sampai])->sum('kredit');
                          @endphp
                            <div class="card-header">
                                <h5 class="float-left">Jurnal Pemasukan {{ date('d F Y', strtotime($dari)); }} ~ {{ date('d F Y', strtotime($sampai)); }}</h5>
                                <a href="" data-toggle="modal" data-target="#view"
                                    class="btn btn-info btn-sm float-right mr-1"><i class="fas fa-eye"></i> View</a>
                                <a href="{{ route('exportJPemasukan',['dari' => $dari, 'sampai' => $sampai]) }}"
                                    class="btn btn-info btn-sm float-right mr-1"><i class="fas fa-file-export"></i> Export
                                </a>
                                <a href="" data-toggle="modal" data-target="#tambah"
                                    class="btn btn-info btn-sm float-right mr-1"><i class="fas fa-plus"></i>
                                    Pemasukan</a>
                            </div>
                            <div class="card-body">
                                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-striped dataTable no-footer" id="table" role="grid"
                                                aria-describedby="table_info">
                                                <thead>
                                                    <tr class="table-info">
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>No Invoice</th>
                                                        <th>Keterangan</th>
                                                        <th>No Akun</th>
                                                        <th>Nama Akun</th>
                                                        <th>Debit <span class="ml-1"></span><b>({{ number_format($tDebit, 0) }})</b></th>
                                                        <th>Kredit <span class="ml-1"></span><b>({{ number_format($tKredit, 0) }})</b></th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($jurnal as $j)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{$j->tgl}}</td>
                                                        <td>{{$j->kd_gabungan}}</td>
                                                        <td>{{$j->ket}}</td>
                                                        <td>{{ $j->no_akun }}</td>
                                                        <td>{{$j->nm_akun}}</td>
                                                        <td>{{ number_format($j->debit,0) }}</td>
                                                        <td>{{number_format($j->kredit,0)}}</td>
                                                        <td>
                                                            <a href="" class="btn btn-sm btn-outline-secondary"><i class="fa fa-edit"></i></a>
                                                            <a href="{{ route('delJpem') }}" class="btn btn-sm btn-outline-secondary"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr> 
                                                    @endforeach
                                                
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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


    <div class="modal fade" id="tambah" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-max" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background:#fadadd;">
                  <h5 class="modal-title" id="exampleModalLabel">Jurnal Pemasukan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
        
                  <div class="row">
        
                    <div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label for="list_kategori">Tanggal</label>
                        <input class="form-control" type="date" name="tgl" value="2022-03-24" required="">
        
                      </div>
                    </div>
        
                    <!-- <div class="mt-3 ml-1">
                      <p class="mt-4 ml-2 text-warning"><strong>Db</strong></p>
                    </div> -->
        
        
                    <div class="col-sm-3 col-md-3" data-select2-id="139">
                      <div class="form-group">
                        <label for="list_kategori">Akun</label>
                        <select name="" id="">
                          <option value="">Kas</option>
                        </select>
                      </div>
                    </div>
        
                    <div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label for="list_kategori">Keterangan</label>
                        <input type="text" name="ket_debit[]" class="form-control" value="">
                      </div>
                    </div>
        
                    <div class="col-sm-2 col-md-2">
                      <div class="form-group">
                        <label for="list_kategori">Debit</label>
                        <input type="text" class="form-control debit" name="debit[]" required="">
                      </div>
                    </div>
                    </div>
        
                    <div id="debit_pengeluaran">
        
        
                    </div>
        
                    <div class="row justify-content-end">
        
                      <label align="right" class="col-md-2 col-form-label">Total Debit</label>      
        
                      <div class="col-md-2">
                          <input type="text" class="form-control" id="ttl_debit" readonly="">
              
                      </div>
        
                      <div class="col-md-1">
                        <button type="button" id="tambah_debit_pengeluaran" class="btn btn-sm btn-success"><i class="fas fa-plus-square"></i></button>
                      </div>
          
                    </div>        
                    <hr style="border: 1px solid;">
                    <br>
                    
                    <div class="row">        
                    <div class="col-sm-3 col-md-3">
        
                    </div>
        
                    <!-- <div class="mt-3">
                      <p class="mt-3 ml-3 text-warning"><strong>Cr</strong></p>
                    </div> -->
        
                    <div class="col-sm-3 col-md-3">
                      <div class="form-group">
                      <label for="list_kategori">Akun</label>
                        <select name="" id="" class="form-control select">
                          <option value="">Kas</option>
                        </select>
                      </div>
                    </div>
        
                    <div class="col-sm-3 col-md-3">
                      <div class="form-group">
                        <label for="list_kategori">Keterangan</label>
                        <input type="text" class="form-control" name="ket_kredit[]" value="">
                      </div>
                    </div>
        
                    <div class="col-sm-2 col-md-2">
                      <div class="form-group">
                        <label for="list_kategori">Kredit</label>
                        <input type="text" class="form-control kredit" name="kredit[]" required="">
                      </div>
                    </div>
        
                </div>
        
                <div id="kredit_pengeluaran">
        
        
                </div>
        
                <div class="row justify-content-end">
        
                      <label align="right" class="col-md-2 col-form-label">Total Kredit</label>      
        
                      <div class="col-md-2">
                        <input type="text" class="form-control" id="ttl_kredit" readonly="">
              
                      </div>
        
                      <div class="col-md-1">
                        <button type="button" id="tambah_kredit_pengeluaran" class="btn btn-sm btn-success"><i class="fas fa-plus-square"></i></button>
                      </div>    
                    </div>
        
                    <hr style="border: 1px solid;">        
                    <br>        
        
                <div class="row justify-content-end">
        
                  <label align="right" class="col-md-1 col-form-label">Selisih</label>        
        
                    <div class="col-md-2">
                      <div class="form-group">
                        <input type="text" class="form-control" id="ttl" readonly="">
                      </div>      
                    </div>
        
                    <div class="col-md-1" id="total">
                    <div class="btn btn-sm btn-danger">
                    <i class="fas fa-times-circle"></i>
                    </div>
                    
                    </div>        
        
                </div>  
        
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="input" disabled="">Input</button>
                </div>
              </div>
        </div>
    </div>


    {{-- modal export pertanggal --}}
    <form action="{{ route('jPemasukan', ['acc' => Request::get('acc')]) }}" method="get">
      <div class="modal fade" id="view" tabindex="-1" role="dialog"
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
