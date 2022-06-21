@extends('template.master')
@section('content')
<?php $l = 1; 
$point = 0;
$point2 = 0;
foreach ($masak as $k) : ?>
<?php $o = $l++ ?>
<?php $point += $k->point_berhasil + $k->point_gagal ?>


<?php  endforeach ?>






<div class="content-wrapper" style="min-height: 511px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2 justify-content-center">
                <div class="col-sm-12">
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php $service_charge = $service->total * 0.07; ?>
    <?php if(empty($o)): ?>
    <?php $orang =  '0'  ?>
    <?php else: ?>
    <?php $orang =  $o  ?>
    <?php endif ?>


    <?php $kom =  (((($service_charge  / 7 ) * $persen->jumlah_persen) / $jumlah_orang->jumlah)  * $orang)  ?>


    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5>Org p/r :
                                <?= number_format($jumlah_orang->jumlah,0) ?> /
                                <?= number_format($orang,0) ?>
                            </h5>

                            <h5>Service charge p/r :
                                <?= number_format(($service_charge / 7) * $persen->jumlah_persen,0) ?> /
                                <?= number_format($kom,0) ?>

                            </h5>
                        </div>
                        <div class="col-lg-6">
                            <a href="" data-target="#view" data-toggle="modal"
                                class="btn btn-info float-right btn-sm "><i class="fas fa-eye"></i> View</a>
                            <a href="{{ route('point_export')}}?tgl1={{$tgl1}}&tgl2={{$tgl2}}"
                                class="btn btn-info float-right btn-sm mr-2"><i class="fas fa-file-excel"></i>
                                Export</a>
                        </div>
                    </div>


                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="font-weight: bold">
                                Point masak
                                <?= date('d-m-Y',strtotime($tgl1)) ?> ~
                                <?= date('d-m-Y',strtotime($tgl2)) ?>
                            </h5>
                        </div>
                        <div class="card-body">

                            <table width="100%" class="table " id="table10" style="font-size: 11px">
                                <thead style="white-space: nowrap; ">
                                    <tr>
                                        <th>#</th>
                                        <th style="font-size: 10px;text-align: center">Nama</th>
                                        <th style="font-size: 10px;text-align: right">Point <br> Masak </th>
                                        <th style="font-size: 10px;text-align: right">Non Point <br> Masak</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; foreach ($masak as $k) : ?>
                                    <tr>
                                        <td>
                                            <?= $i++ ?>
                                        </td>
                                        <td>
                                            <?= $k->nama ?>
                                        </td>
                                        <?php $kom1 = $point == '' ? '0' :  ($k->point_berhasil / $point) * $kom  ?>

                                        <td style="text-align: right">
                                            <?= number_format($k->point_berhasil,0) ?> /
                                            <?= number_format($kom1,0) ?>
                                        </td>
                                        <?php $kom3 =  $point == '' ? '0' : ($k->point_gagal / $point) * $kom  ?>

                                        <td style="text-align: right">
                                            <?= number_format($k->point_gagal,0) ?> /
                                            <?= number_format($kom3,0) ?>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="font-weight: bold">
                                Total Absen
                                <?= date('d-m-Y',strtotime($tgl1)) ?> ~
                                <?= date('d-m-Y',strtotime($tgl2)) ?>
                            </h5>
                        </div>
                        <div class="card-body">

                            <table width="100%" class="table " id="table" style="font-size: 11px">
                                <thead style="white-space: nowrap; ">
                                    <tr>
                                        <th>#</th>
                                        <th style="font-size: 10px;text-align: center">Nama</th>
                                        <th style="font-size: 10px;text-align: right">M</th>
                                        <th style="font-size: 10px;text-align: right">E</th>
                                        <th style="font-size: 10px;text-align: right">SP</th>
                                        <th style="font-size: 10px;text-align: right">Rp M</th>
                                        <th style="font-size: 10px;text-align: right">Gaji</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; foreach ($masak as $k) : ?>
                                    <tr>
                                        <td>
                                            <?= $i++ ?>
                                        </td>
                                        <td>
                                            <?= $k->nama ?>
                                        </td>
                                        <td style="text-align: right">
                                            <?= number_format($k->qty_m,0) ?>
                                        </td>
                                        <td style="text-align: right">
                                            <?= number_format($k->qty_e,0) ?>
                                        </td>
                                        <td style="text-align: right">
                                            <?= number_format($k->qty_sp,0) ?>
                                        </td>
                                        {{-- <td style="text-align: right">
                                            <?= number_format($k->qty_e+ $k->qty_m+$k->qty_sp,0) ?>
                                        </td> --}}
                                        <td style="text-align: right">
                                            <?= number_format($k->rp_m,0) ?>
                                        </td>
                                        <?php $gaji = ($k->rp_m * $k->qty_m) + ($k->rp_e * $k->qty_e) + ($k->rp_sp * $k->qty_sp)  ?>
                                        <td style="text-align: right">
                                            <?= number_format($gaji,0) ?>
                                        </td>


                                    </tr>
                                    <?php endforeach ?>
                                </tbody>

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

<form action="" method="get">
    <div class="modal fade" role="dialog" id="view" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content ">
                <div class="modal-header btn-costume">
                    <h5 class="modal-title text-light" id="exampleModalLabel">View Tanggal</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Dari</label>
                            <input class="form-control" type="date" name="tgl1">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Sampai</label>
                            <input class="form-control" type="date" name="tgl2">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </div>
        </div>
    </div>
</form>



@endsection
@section('script')

@endsection