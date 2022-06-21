<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Str;
use DateTime;

class Point_masak extends Controller
{
    public function index(Request $r)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)->where('id_menu', 28)->first();
        if (empty($id_menu)) {
            return back();
        } else {
            $id_lokasi = $r->session()->get('id_lokasi');
            if (empty($r->tgl1)) {
                $tgl1 = date('Y-m-01');
                $tgl2 = date('Y-m-d');
            } else {
                $tgl1 = $r->tgl1;
                $tgl2 = $r->tgl2;
            }



            $total_not_gojek = DB::selectOne("SELECT SUM(if(tb_transaksi.total_orderan - discount - voucher < 0 ,0,tb_transaksi.total_orderan - discount - voucher)) as total FROM `tb_transaksi`
            LEFT JOIN(SELECT tb_order2.no_order2 as no_order, tb_order2.id_distribusi as id_distribusi FROM tb_order2 GROUP BY tb_order2.no_order2) dt_order ON tb_transaksi.no_order = dt_order.no_order
            WHERE tb_transaksi.id_lokasi = '$id_lokasi' and  dt_order.id_distribusi != '2' AND tb_transaksi.tgl_transaksi >= '$tgl1' AND tb_transaksi.tgl_transaksi <= '$tgl2'");

            $masak = DB::select("SELECT a.nama,b.rp_m, sum(l.qty_m) AS qty_m, sum(l.qty_e) AS qty_e, sum(l.qty_sp) AS qty_sp,e.point_gagal,f.point_berhasil, b.rp_e, b.rp_sp
            FROM tb_karyawan AS a
            left join tb_gaji AS b ON b.id_karyawan = a.id_karyawan
            LEFT JOIN (
                    SELECT c.id_karyawan,  c.status, c.id_lokasi,
                    if(c.status = 'M', COUNT(c.status), 0) AS qty_m,
                    if(c.status = 'E', COUNT(c.status), 0) AS qty_e,
                    if(c.status = 'SP', COUNT(c.status), 0) AS qty_sp,
                    if(c.status = 'OFF', COUNT(c.status), 0) AS qty_off
                    FROM tb_absen AS c 
                    WHERE c.tgl BETWEEN '$tgl1' AND '$tgl2' and c.id_lokasi = '$id_lokasi'
                    GROUP BY c.id_karyawan, c.status
                    ) AS l ON l.id_karyawan = a.id_karyawan
                    
                    LEFT JOIN (
                    SELECT koki, SUM(nilai_koki) as point_gagal FROM view_nilai_masak2 
                    WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND lama_masak > 30 and id_lokasi = '$id_lokasi'
                    GROUP BY koki , id_lokasi
                    )e ON a.id_karyawan = e.koki
                    
                    LEFT JOIN (
                        SELECT koki, SUM(nilai_koki) as point_berhasil FROM view_nilai_masak2 
                        WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND lama_masak <= 30 and id_lokasi = '$id_lokasi'
                        GROUP BY koki , id_lokasi
                    )f ON a.id_karyawan = f.koki


                        WHERE a.id_status = '1' and a.tgl_masuk <= '$tgl2' and l.id_lokasi ='$id_lokasi' and a.id_posisi not in ('3','2')
                        group by a.id_karyawan
        ");
            $server = DB::select("SELECT a.nama, b.rp_m, sum(l.qty_m) AS qty_m, sum(l.qty_e) AS qty_e, sum(l.qty_sp) AS qty_sp, b.rp_e, b.rp_sp, b.komisi
        FROM tb_karyawan AS a
        left join tb_gaji AS b ON b.id_karyawan = a.id_karyawan
        LEFT JOIN (
               SELECT c.id_karyawan,  c.status, c.id_lokasi,
                if(c.status = 'M', COUNT(c.status), 0) AS qty_m,
                if(c.status = 'E', COUNT(c.status), 0) AS qty_e,
                if(c.status = 'SP', COUNT(c.status), 0) AS qty_sp,
                if(c.status = 'OFF', COUNT(c.status), 0) AS qty_off
                FROM tb_absen AS c 
                WHERE c.tgl BETWEEN '$tgl1' AND '$tgl2' and c.id_lokasi = '$id_lokasi'
                GROUP BY c.id_karyawan, c.status
                ) AS l ON l.id_karyawan = a.id_karyawan

        LEFT JOIN (
        SELECT a.admin, SUM(if(a.voucher != '0' ,0, a.hrg )) AS komisi
        FROM view_summary_server AS a
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.admin
        ) AS b ON b.admin = a.nama

                WHERE  a.tgl_masuk <= '$tgl2' and l.id_lokasi ='$id_lokasi' and a.id_status ='2'
                group by a.id_karyawan
            


                    
    ");
            $data = [
                'title' => 'Point Masak',
                'masak' => $masak,
                'server' => $server,
                'tgl1' => $tgl1,
                'tgl2' => $tgl2,
                'service' => $total_not_gojek,
                'jumlah_orang' => DB::table('tb_jumlah_orang')->where('ket_karyawan', 'Kitchen')->where('id_lokasi', $id_lokasi)->first(),
                'persen' => DB::table('persentse_komisi')->where('nama_persentase', 'Kitchen')->where('id_lokasi', $id_lokasi)->first(),
                'jumlah_orang2' => DB::table('tb_jumlah_orang')->where('ket_karyawan', 'Server')->where('id_lokasi', $id_lokasi)->first(),
                'persen2' => DB::table('persentse_komisi')->where('nama_persentase', 'Server')->where('id_lokasi', $id_lokasi)->first(),
                'logout' => $r->session()->get('logout'),
            ];

            return view('point_masak.point_masak', $data);
        }
    }
    public function point_kitchen(Request $r)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)->where('id_menu', 28)->first();
        if (empty($id_menu)) {
            return back();
        } else {
            if (empty($r->id_lokasi)) {
                $id_lokasi = 1;
            } else {
                $id_lokasi = $r->id_lokasi;
            }

            if (empty($r->tgl1)) {
                $tgl1 = date('Y-m-01');
                $tgl2 = date('Y-m-d');
            } else {
                $tgl1 = $r->tgl1;
                $tgl2 = $r->tgl2;
            }



            $total_not_gojek = DB::selectOne("SELECT SUM(if(tb_transaksi.total_orderan - discount - voucher < 0 ,0,tb_transaksi.total_orderan - discount - voucher)) as total FROM `tb_transaksi`
            LEFT JOIN(SELECT tb_order2.no_order2 as no_order, tb_order2.id_distribusi as id_distribusi FROM tb_order2 GROUP BY tb_order2.no_order2) dt_order ON tb_transaksi.no_order = dt_order.no_order
            WHERE tb_transaksi.id_lokasi = '$id_lokasi' and  dt_order.id_distribusi != '2' AND tb_transaksi.tgl_transaksi >= '$tgl1' AND tb_transaksi.tgl_transaksi <= '$tgl2'");

            $masak = DB::select("SELECT a.nama,b.rp_m, sum(l.qty_m) AS qty_m, sum(l.qty_e) AS qty_e, sum(l.qty_sp) AS qty_sp,e.point_gagal,f.point_berhasil, b.rp_e, b.rp_sp
            FROM tb_karyawan AS a
            left join tb_gaji AS b ON b.id_karyawan = a.id_karyawan
            LEFT JOIN (
                    SELECT c.id_karyawan,  c.status, c.id_lokasi,
                    if(c.status = 'M', COUNT(c.status), 0) AS qty_m,
                    if(c.status = 'E', COUNT(c.status), 0) AS qty_e,
                    if(c.status = 'SP', COUNT(c.status), 0) AS qty_sp,
                    if(c.status = 'OFF', COUNT(c.status), 0) AS qty_off
                    FROM tb_absen AS c 
                    WHERE c.tgl BETWEEN '$tgl1' AND '$tgl2' and c.id_lokasi = '$id_lokasi'
                    GROUP BY c.id_karyawan, c.status
                    ) AS l ON l.id_karyawan = a.id_karyawan
                    
                    LEFT JOIN (
                    SELECT koki, SUM(nilai_koki) as point_gagal FROM view_nilai_masak2 
                    WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND lama_masak > 30 and id_lokasi = '$id_lokasi'
                    GROUP BY koki , id_lokasi
                    )e ON a.id_karyawan = e.koki
                    
                    LEFT JOIN (
                        SELECT koki, SUM(nilai_koki) as point_berhasil FROM view_nilai_masak2 
                        WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND lama_masak <= 30 and id_lokasi = '$id_lokasi'
                        GROUP BY koki , id_lokasi
                    )f ON a.id_karyawan = f.koki


                        WHERE a.id_status = '1' and a.tgl_masuk <= '$tgl2' and l.id_lokasi ='$id_lokasi' and a.id_posisi not in ('3','2')
                        group by a.id_karyawan
        ");
            $data = [
                'title' => 'Point Masak',
                'masak' => $masak,
                'tgl1' => $tgl1,
                'tgl2' => $tgl2,
                'id_lokasi' => $id_lokasi,
                'service' => $total_not_gojek,
                'jumlah_orang' => DB::table('tb_jumlah_orang')->where('ket_karyawan', 'Kitchen')->where('id_lokasi', $id_lokasi)->first(),
                'persen' => DB::table('persentse_komisi')->where('nama_persentase', 'Kitchen')->where('id_lokasi', $id_lokasi)->first(),
                'logout' => $r->session()->get('logout'),
            ];

            return view('point_masak.point_kitchen', $data);
        }
    }

    public function point_export(Request $r)
    {
        $id_lokasi = $r->session()->get('id_lokasi');
        if (empty($r->tgl1)) {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-d');
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }

        $service = DB::selectOne("SELECT SUM(if(tb_transaksi.total_orderan - discount - voucher < 0 ,0,tb_transaksi.total_orderan - discount - voucher)) as total FROM `tb_transaksi`
        LEFT JOIN(SELECT tb_order2.no_order2 as no_order, tb_order2.id_distribusi as id_distribusi FROM tb_order2 GROUP BY tb_order2.no_order2) dt_order ON tb_transaksi.no_order = dt_order.no_order
        WHERE tb_transaksi.id_lokasi = '$id_lokasi' and  dt_order.id_distribusi != '2' AND tb_transaksi.tgl_transaksi >= '$tgl1' AND tb_transaksi.tgl_transaksi <= '$tgl2'");

        $jumlah_orang = DB::table('tb_jumlah_orang')->where('ket_karyawan', 'Kitchen')->where('id_lokasi', $id_lokasi)->first();
        $persen = DB::table('persentse_komisi')->where('nama_persentase', 'Kitchen')->where('id_lokasi', $id_lokasi)->first();

        $masak = DB::select("SELECT a.nama,b.rp_m, sum(l.qty_m) AS qty_m, sum(l.qty_e) AS qty_e, sum(l.qty_sp) AS qty_sp,e.point_gagal,f.point_berhasil, b.rp_e, b.rp_sp
        FROM tb_karyawan AS a
        left join tb_gaji AS b ON b.id_karyawan = a.id_karyawan
        LEFT JOIN (
        SELECT c.id_karyawan,  c.status, c.id_lokasi,
        if(c.status = 'M', COUNT(c.status), 0) AS qty_m,
        if(c.status = 'E', COUNT(c.status), 0) AS qty_e,
        if(c.status = 'SP', COUNT(c.status), 0) AS qty_sp,
        if(c.status = 'OFF', COUNT(c.status), 0) AS qty_off
        FROM tb_absen AS c 
        WHERE c.tgl BETWEEN '$tgl1' AND '$tgl2' and c.id_lokasi = '$id_lokasi'
        GROUP BY c.id_karyawan, c.status
        ) AS l ON l.id_karyawan = a.id_karyawan
        
        LEFT JOIN (
        SELECT koki, SUM(nilai_koki) as point_gagal FROM view_nilai_masak2 
        WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND lama_masak > 30 and id_lokasi = '$id_lokasi'
        GROUP BY koki , id_lokasi
        )e ON a.id_karyawan = e.koki
        
        LEFT JOIN (
            SELECT koki, SUM(nilai_koki) as point_berhasil FROM view_nilai_masak2 
            WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND lama_masak <= 30 and id_lokasi = '$id_lokasi'
            GROUP BY koki , id_lokasi
        )f ON a.id_karyawan = f.koki
            WHERE a.id_status = '1' and a.tgl_masuk <= '$tgl2' and l.id_lokasi ='$id_lokasi' and a.id_posisi not in ('3','2')
            group by a.id_karyawan
        ");

        $l = 1;
        $point = 0;
        $point2 = 0;
        foreach ($masak as $m) {
            $orang = $l++;
            $point += $m->point_berhasil + $m->point_gagal;
        }

        $service_charge = $service->total * 0.07;
        $kom =  round((((($service_charge  / 7) * $persen->jumlah_persen) / $jumlah_orang->jumlah)  * $orang));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('Point Masak');

        $sheet->getStyle('A1:F1')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        // lebar kolom
        $sheet->getColumnDimension('A')->setWidth(3);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(17);
        $sheet->getColumnDimension('E')->setWidth(17);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(17);
        $sheet->getColumnDimension('H')->setWidth(21);
        $sheet->getColumnDimension('J')->setWidth(17);
        // header text
        $sheet
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'NAMA KARYAWAN')
            ->setCellValue('C1', 'POINT MASAK')
            ->setCellValue('D1', 'KOM POINT MASAK')
            ->setCellValue('E1', 'NON POINT MASAK')
            ->setCellValue('F1', 'KOM NON POINT MASAK')
            ->setCellValue('H1', 'Org P ')
            ->setCellValue('I1', $jumlah_orang->jumlah)
            ->setCellValue('H2', 'Org R ')
            ->setCellValue('I2', $orang)
            ->setCellValue('H4', 'Service charge P ')
            ->setCellValue('I4', ($service_charge / 7) * $persen->jumlah_persen)
            ->setCellValue('H5', 'Service charge R')
            ->setCellValue('I5', $kom);
        $kolom = 2;



        $i = 1;
        foreach ($masak as $k) {
            $sheet->setCellValue('A' . $kolom, $i++);
            $sheet->setCellValue('B' . $kolom, $k->nama);
            $kom1 =  round(($k->point_berhasil / $point) * $kom, 0);
            $sheet->setCellValue('C' . $kolom, $k->point_berhasil);
            $sheet->setCellValue('D' . $kolom, $kom1);
            $sheet->setCellValue('E' . $kolom, $k->point_gagal);
            $kom3 =  round(($k->point_gagal / $point) * $kom);
            $sheet->setCellValue('F' . $kolom, $kom3);
            $kolom++;
        }

        $writer = new Xlsx($spreadsheet);
        $style = [
            'borders' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];
        $batas = $masak;
        $batas = count($batas) + 1;
        $sheet->getStyle('A1:F' . $batas)->applyFromArray($style);

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);

        $sheet2 = $spreadsheet->getActiveSheet();
        $sheet2->setTitle('Absensi');

        // lebar kolom
        $sheet2->getColumnDimension('A')->setWidth(3);
        $sheet2->getColumnDimension('B')->setWidth(20);
        $sheet2->getColumnDimension('C')->setWidth(15);
        $sheet2->getColumnDimension('D')->setWidth(14.36);
        $sheet2->getColumnDimension('E')->setWidth(13);
        $sheet2->getColumnDimension('F')->setWidth(16.9);
        $sheet2->getColumnDimension('G')->setWidth(16);
        $sheet2->getColumnDimension('J')->setWidth(13);
        $sheet2->getColumnDimension('K')->setWidth(14);
        $sheet2->getColumnDimension('L')->setWidth(14);
        // header text
        $sheet2
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'M')
            ->setCellValue('D1', 'E')
            ->setCellValue('E1', 'SP')
            ->setCellValue('F1', 'Rp M')
            ->setCellValue('G1', 'Gaji');

        $kolom = 2;
        $i = 1;
        foreach ($masak as $k) {
            $spreadsheet->setActiveSheetIndex(1);
            $sheet2->setCellValue('A' . $kolom, $i++);
            $sheet2->setCellValue('B' . $kolom, $k->nama);
            $sheet2->setCellValue('C' . $kolom, $k->qty_m);
            $sheet2->setCellValue('D' . $kolom, $k->qty_e);
            $sheet2->setCellValue('E' . $kolom, $k->qty_sp);
            $sheet2->setCellValue('F' . $kolom, $k->rp_m);
            $gaji = ($k->rp_m * $k->qty_m) + ($k->rp_e * $k->qty_e) + ($k->rp_sp * $k->qty_sp);
            $sheet2->setCellValue('G' . $kolom, $gaji);
            $kolom++;
        }

        $writer = new Xlsx($spreadsheet);
        $style = [
            'borders' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];
        $batas = $masak;
        $batas = count($batas) + 1;
        $sheet2->getStyle('A1:G' . $batas)->applyFromArray($style);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="POINT-TS.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
    public function point_export_server(Request $r)
    {
        if (empty($r->id_lokasi)) {
            $id_lokasi = 1;
        } else {
            $id_lokasi = $r->id_lokasi;
        }
        if (empty($r->tgl1)) {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-d');
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }
        $service = DB::selectOne("SELECT SUM(if(tb_transaksi.total_orderan - discount - voucher < 0 ,0,tb_transaksi.total_orderan - discount - voucher)) as total FROM `tb_transaksi`
        LEFT JOIN(SELECT tb_order2.no_order2 as no_order, tb_order2.id_distribusi as id_distribusi FROM tb_order2 GROUP BY tb_order2.no_order2) dt_order ON tb_transaksi.no_order = dt_order.no_order
        WHERE tb_transaksi.id_lokasi = '$id_lokasi' and  dt_order.id_distribusi != '2' AND tb_transaksi.tgl_transaksi >= '$tgl1' AND tb_transaksi.tgl_transaksi <= '$tgl2'");

        $jumlah_orang = DB::table('tb_jumlah_orang')->where('ket_karyawan', 'Kitchen')->where('id_lokasi', $id_lokasi)->first();
        $persen = DB::table('persentse_komisi')->where('nama_persentase', 'Kitchen')->where('id_lokasi', $id_lokasi)->first();

        $masak = DB::select("SELECT a.nama,b.rp_m, sum(l.qty_m) AS qty_m, sum(l.qty_e) AS qty_e, sum(l.qty_sp) AS qty_sp,e.point_gagal,f.point_berhasil, b.rp_e, b.rp_sp
        FROM tb_karyawan AS a
        left join tb_gaji AS b ON b.id_karyawan = a.id_karyawan
        LEFT JOIN (
        SELECT c.id_karyawan,  c.status, c.id_lokasi,
        if(c.status = 'M', COUNT(c.status), 0) AS qty_m,
        if(c.status = 'E', COUNT(c.status), 0) AS qty_e,
        if(c.status = 'SP', COUNT(c.status), 0) AS qty_sp,
        if(c.status = 'OFF', COUNT(c.status), 0) AS qty_off
        FROM tb_absen AS c 
        WHERE c.tgl BETWEEN '$tgl1' AND '$tgl2' and c.id_lokasi = '$id_lokasi'
        GROUP BY c.id_karyawan, c.status
        ) AS l ON l.id_karyawan = a.id_karyawan
        
        LEFT JOIN (
        SELECT koki, SUM(nilai_koki) as point_gagal FROM view_nilai_masak2 
        WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND lama_masak > 30 and id_lokasi = '$id_lokasi'
        GROUP BY koki , id_lokasi
        )e ON a.id_karyawan = e.koki
        
        LEFT JOIN (
            SELECT koki, SUM(nilai_koki) as point_berhasil FROM view_nilai_masak2 
            WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND lama_masak <= 30 and id_lokasi = '$id_lokasi'
            GROUP BY koki , id_lokasi
        )f ON a.id_karyawan = f.koki
            WHERE a.id_status = '1' and a.tgl_masuk <= '$tgl2' and l.id_lokasi ='$id_lokasi' and a.id_posisi not in ('3','2')
            group by a.id_karyawan
        ");

        $l = 1;
        $point = 0;
        $point2 = 0;
        foreach ($masak as $m) {
            $orang = $l++;
            $point += $m->point_berhasil + $m->point_gagal;
        }

        $service_charge = $service->total * 0.07;
        $kom =  round((((($service_charge  / 7) * $persen->jumlah_persen) / $jumlah_orang->jumlah)  * $orang));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('Point Masak');

        $sheet->getStyle('A1:F1')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        // lebar kolom
        $sheet->getColumnDimension('A')->setWidth(3);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(17);
        $sheet->getColumnDimension('E')->setWidth(17);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(17);
        $sheet->getColumnDimension('H')->setWidth(21);
        $sheet->getColumnDimension('J')->setWidth(17);
        // header text
        $sheet
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'NAMA KARYAWAN')
            ->setCellValue('C1', 'POINT MASAK')
            ->setCellValue('D1', 'KOM POINT MASAK')
            ->setCellValue('E1', 'NON POINT MASAK')
            ->setCellValue('F1', 'KOM NON POINT MASAK')
            ->setCellValue('H1', 'Org P ')
            ->setCellValue('I1', $jumlah_orang->jumlah)
            ->setCellValue('H2', 'Org R ')
            ->setCellValue('I2', $orang)
            ->setCellValue('H4', 'Service charge P ')
            ->setCellValue('I4', ($service_charge / 7) * $persen->jumlah_persen)
            ->setCellValue('H5', 'Service charge R')
            ->setCellValue('I5', $kom);
        $kolom = 2;



        $i = 1;
        foreach ($masak as $k) {
            $sheet->setCellValue('A' . $kolom, $i++);
            $sheet->setCellValue('B' . $kolom, $k->nama);
            $kom1 =  round(($k->point_berhasil / $point) * $kom, 0);
            $sheet->setCellValue('C' . $kolom, $k->point_berhasil);
            $sheet->setCellValue('D' . $kolom, $kom1);
            $sheet->setCellValue('E' . $kolom, $k->point_gagal);
            $kom3 =  round(($k->point_gagal / $point) * $kom);
            $sheet->setCellValue('F' . $kolom, $kom3);
            $kolom++;
        }

        $writer = new Xlsx($spreadsheet);
        $style = [
            'borders' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];
        $batas = $masak;
        $batas = count($batas) + 1;
        $sheet->getStyle('A1:F' . $batas)->applyFromArray($style);

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);

        $sheet2 = $spreadsheet->getActiveSheet();
        $sheet2->setTitle('Absensi');

        // lebar kolom
        $sheet2->getColumnDimension('A')->setWidth(3);
        $sheet2->getColumnDimension('B')->setWidth(20);
        $sheet2->getColumnDimension('C')->setWidth(15);
        $sheet2->getColumnDimension('D')->setWidth(14.36);
        $sheet2->getColumnDimension('E')->setWidth(13);
        $sheet2->getColumnDimension('F')->setWidth(16.9);
        $sheet2->getColumnDimension('G')->setWidth(16);
        $sheet2->getColumnDimension('J')->setWidth(13);
        $sheet2->getColumnDimension('K')->setWidth(14);
        $sheet2->getColumnDimension('L')->setWidth(14);
        // header text
        $sheet2
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'M')
            ->setCellValue('D1', 'E')
            ->setCellValue('E1', 'SP')
            ->setCellValue('F1', 'Rp M')
            ->setCellValue('G1', 'Gaji');

        $kolom = 2;
        $i = 1;
        foreach ($masak as $k) {
            $spreadsheet->setActiveSheetIndex(1);
            $sheet2->setCellValue('A' . $kolom, $i++);
            $sheet2->setCellValue('B' . $kolom, $k->nama);
            $sheet2->setCellValue('C' . $kolom, $k->qty_m);
            $sheet2->setCellValue('D' . $kolom, $k->qty_e);
            $sheet2->setCellValue('E' . $kolom, $k->qty_sp);
            $sheet2->setCellValue('F' . $kolom, $k->rp_m);
            $gaji = ($k->rp_m * $k->qty_m) + ($k->rp_e * $k->qty_e) + ($k->rp_sp * $k->qty_sp);
            $sheet2->setCellValue('G' . $kolom, $gaji);
            $kolom++;
        }

        $writer = new Xlsx($spreadsheet);
        $style = [
            'borders' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];
        $batas = $masak;
        $batas = count($batas) + 1;
        $sheet2->getStyle('A1:G' . $batas)->applyFromArray($style);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="POINT-TS.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
