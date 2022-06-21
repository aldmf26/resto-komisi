<?php

namespace App\Http\Controllers;

use App\Exports\GajiExport;
use App\Models\Gaji;
use App\Models\Karyawan;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\Posisi;
use App\Models\Absen;
use Illuminate\Support\Str;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 22)->first();
        if (empty($id_menu)) {
            return back();
        } else {
            if (Auth::user()->jenis == 'adm') {
                $data = [
                    'title' => 'Gaji',
                    'logout' => $request->session()->get('logout'),
                    'gaji' => DB::select("SELECT a.*, b.*, c.id_gaji, c.rp_e, c.rp_m, c.rp_sp, c.g_bulanan FROM tb_karyawan as a LEFT JOIN tb_posisi as b ON a.id_posisi =  b.id_posisi LEFT JOIN tb_gaji as c ON a.id_karyawan = c.id_karyawan ORDER BY a.tgl_masuk DESC"),
                ];

                return view('gaji.gaji', $data);
            } else {
                return back();
            }
        }
    }

    public function editGaji(Request $request)
    {
        $id_gaji = $request->id_gaji;
        $id_karyawan = $request->id_karyawan;
        if (empty($id_gaji)) {
            $data = [
                'id_karyawan' => $id_karyawan,
                'rp_m' => $request->rp_m,
                'rp_e' => $request->rp_e,
                'rp_sp' => $request->rp_sp,
                'g_bulanan' => $request->g_bulanan,
            ];
            Gaji::create($data);
        } else {
            $data = [
                'rp_m' => $request->rp_m,
                'rp_e' => $request->rp_e,
                'rp_sp' => $request->rp_sp,
                'g_bulanan' => $request->g_bulanan,
            ];
            Gaji::where('id_gaji', $id_gaji)->update($data);
        }
        return redirect()->route('gaji');
    }

    public function gajiExport()
    {
        $gaji = DB::select("SELECT a.*, b.*, c.id_gaji, c.rp_e, c.rp_m, c.rp_sp, c.g_bulanan FROM tb_karyawan as a LEFT JOIN tb_posisi as b ON a.id_posisi =  b.id_posisi LEFT JOIN tb_gaji as c ON a.id_karyawan = c.id_karyawan ORDER BY a.tgl_masuk DESC");


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1:D4')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        // lebar kolom
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(13);
        $sheet->getColumnDimension('G')->setWidth(13);
        $sheet->getColumnDimension('H')->setWidth(13);
        $sheet->getColumnDimension('I')->setWidth(13);
        // header text
        $sheet
            ->setCellValue('A1', 'ID KARYAWAN')
            ->setCellValue('B1', 'NAMA')
            ->setCellValue('C1', 'POSISI')
            ->setCellValue('D1', 'TANGGAL MASUK')
            ->setCellValue('E1', 'LAMA')
            ->setCellValue('F1', 'RP E')
            ->setCellValue('G1', 'RP M')
            ->setCellValue('H1', 'RP SP')
            ->setCellValue('I1', 'BULANAN');
        $kolom = 2;
        $i = 1;
        foreach ($gaji as $k) {
            $totalKerja = new DateTime($k->tgl_masuk);
            $today = new DateTime();
            $tKerja = $today->diff($totalKerja);
            $sheet->setCellValue('A' . $kolom, $k->id_karyawan);
            $sheet->setCellValue('B' . $kolom, $k->nama);
            $sheet->setCellValue('C' . $kolom, $k->nm_posisi);
            $sheet->setCellValue('D' . $kolom, $k->tgl_masuk);
            $sheet->setCellValue('E' . $kolom, $tKerja->y . ' Tahun');
            $sheet->setCellValue('F' . $kolom, $k->rp_e);
            $sheet->setCellValue('G' . $kolom, $k->rp_m);
            $sheet->setCellValue('H' . $kolom, $k->rp_sp);
            $sheet->setCellValue('I' . $kolom, $k->g_bulanan);

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
        $batas = $gaji;
        $batas = count($batas) + 1;
        $sheet->getStyle('A1:I' . $batas)->applyFromArray($style);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Gaji Karyawan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function gajiExportTemplate(Request $request)
    {
        $gaji = DB::select("SELECT a.*, b.*, c.id_gaji, c.rp_e, c.rp_m, c.rp_sp, c.g_bulanan FROM tb_karyawan as a LEFT JOIN tb_posisi as b ON a.id_posisi =  b.id_posisi LEFT JOIN tb_gaji as c ON a.id_karyawan = c.id_karyawan ORDER BY a.tgl_masuk DESC");


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1:D4')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        // lebar kolom
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(13);
        $sheet->getColumnDimension('H')->setWidth(13);
        $sheet->getColumnDimension('I')->setWidth(13);
        $sheet->getColumnDimension('J')->setWidth(13);
        
        // posisi
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);
        // header text
        $sheet
            // posisi
            ->setCellValue('K1', 'POSISI')
            ->setCellValue('L1', 'ID POSISI')
            ->setCellValue('M1', 'POSISI')
            ->setCellValue('N1', 'KETERANGAN')
            
            ->setCellValue('A1', 'ID KARYAWAN')
            ->setCellValue('B1', 'NAMA')
            ->setCellValue('C1', 'TANGGAL MASUK')
            ->setCellValue('D1', 'ID POSISI')
            ->setCellValue('E1', 'POSISI')
            ->setCellValue('F1', 'RP E')
            ->setCellValue('G1', 'RP M')
            ->setCellValue('H1', 'RP SP')
            ->setCellValue('I1', 'BULANAN');
        $pos = 2;
        $posisi = Posisi::all();
        foreach ($posisi as $l) {

            $sheet
                ->setCellValue('L' . $pos, $l->id_posisi)
                ->setCellValue('M' . $pos, $l->nm_posisi)
                ->setCellValue('N' . $pos, $l->ket);
            $pos++;
        }
        $kolom = 2;
        $i = 1;
        foreach ($gaji as $k) {
            $totalKerja = new DateTime($k->tgl_masuk);
            $today = new DateTime();
            $tKerja = $today->diff($totalKerja);
            $sheet->setCellValue('A' . $kolom, $k->id_karyawan);
            $sheet->setCellValue('B' . $kolom, $k->nama);
            $sheet->setCellValue('C' . $kolom, $k->tgl_masuk);
            $sheet->setCellValue('D' . $kolom, $k->id_posisi);
            $sheet->setCellValue('E' . $kolom, $k->nm_posisi);
            $sheet->setCellValue('F' . $kolom, $k->rp_e);
            $sheet->setCellValue('G' . $kolom, $k->rp_m);
            $sheet->setCellValue('H' . $kolom, $k->rp_sp);
            $sheet->setCellValue('I' . $kolom, $k->g_bulanan);

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
        $batas = $gaji;
        $batas2 = $posisi;
        $batas = count($batas) + 1;
        $batas2 = count($batas2) + 1;
        $sheet->getStyle('A1:I' . $batas)->applyFromArray($style);
        // $sheet->getStyle('L1:N' . $batas2)->applyFromArray($style);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Gaji Karyawan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function gajiImport(Request $request)
    {
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
        $spreadsheet = $reader->load($file);
        // $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
        // $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $data = array();

        // lokasi
        $numrow = 1;
        foreach ($sheet as $row) {
            if ($row['A'] == '' && $row['B'] == '' && $row['C'] == '' && $row['D'] == '' && $row['E'] == '' && $row['F']) {
                continue;
            }
            if ($numrow > 1) {
                $data = [
                    'rp_e' => $row['F'],
                    'rp_m' => $row['G'],
                    'rp_sp' => $row['H'],
                    'g_bulanan' => $row['I'],
                ];
                Gaji::where('id_karyawan', $row['A'])->update($data);
                
                Karyawan::where('id_karyawan', $row['A'])->update(['id_posisi' => $row['D'] ]);
                
                Posisi::where('id_posisi', $row['L'])->update(['ket' => $row['N']]);
                
                // if ($row['C'] == '' && $row['D'] == '' && $row['E'] == '' && $row['F'] == '' ) {
                //     $data = [
                //         'id_karyawan' => $row['A'],
                //         'rp_e' => $row['C'],
                //         'rp_m' => $row['D'],
                //         'rp_sp' => $row['E'],
                //         'g_bulanan' => $row['F'],
                //     ];
                //     Gaji::create($data);
                // } else {
                //     $data = [
                //         'rp_e' => $row['C'],
                //         'rp_m' => $row['D'],
                //         'rp_sp' => $row['E'],
                //         'g_bulanan' => $row['F'],
                //     ];
                //     Gaji::where('id_karyawan', $row['A'])->update($data);
                // }
            }
            $numrow++;
        }

        return redirect()->route('karyawan')->with('sukses', 'Berhasil Import');
    }

    public function tabelGaji(Request $request)
    {
        $tgl1 = $request->dari;
        $tgl2 = $request->sampai;
        $gaji = DB::select("SELECT a.nama,tbor.ttl_pengantar, tbora.ttl_admin, a.tgl_masuk , b.rp_e, b.rp_m, b.rp_sp, b.g_bulanan, sum(d.qty_m) AS M, sum(d.qty_e) AS E, sum(d.qty_sp) AS Sp,
        
        gagal_masak.point_gagal, berhasil_masak.point_berhasil, cuci.lama_cuci

        FROM tb_karyawan AS a
        LEFT JOIN tb_gaji AS b ON a.id_karyawan = b.id_karyawan
        
        LEFT JOIN (
        SELECT c.id_karyawan,  c.status,
        if(c.status = 'M', COUNT(c.status), 0) AS qty_m,
        if(c.status = 'E', COUNT(c.status), 0) AS qty_e,
        if(c.status = 'SP', COUNT(c.status), 0) AS qty_sp
        FROM tb_absen AS c 
        WHERE c.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY c.id_karyawan, c.status
        ) AS d ON d.id_karyawan = a.id_karyawan

        LEFT JOIN (
            SELECT koki, SUM(nilai_koki) as point_gagal FROM view_nilai_masak2 
            WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND lama_masak > 30
            GROUP BY koki
        )gagal_masak ON a.id_karyawan = gagal_masak.koki

        LEFT JOIN (
            SELECT COUNT(tbo.pengantar) AS ttl_pengantar,tbo.pengantar, tbo.admin
            FROM tb_order as tbo
            WHERE tbo.tgl BETWEEN '$tgl1' AND '$tgl2'
            GROUP BY tbo.pengantar
        ) AS tbor ON tbor.pengantar = a.nama
        
        LEFT JOIN (
            SELECT COUNT(tboa.admin) AS ttl_admin,tboa.admin
            FROM tb_order as tboa
            WHERE tboa.tgl BETWEEN '$tgl1' AND '$tgl2'
            GROUP BY tboa.admin
        ) AS tbora ON tbora.admin = a.nama

        LEFT JOIN (
            SELECT koki, SUM(nilai_koki) as point_berhasil FROM view_nilai_masak2 
            WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND lama_masak <= 30
            GROUP BY koki
        )berhasil_masak ON a.id_karyawan = berhasil_masak.koki

        LEFT JOIN(
            SELECT nm_karyawan, SUM(lama_cuci) as lama_cuci FROM view_mencuci WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' GROUP BY nm_karyawan
        ) cuci ON a.nama = cuci.nm_karyawan

        GROUP BY a.id_karyawan
        ");

        $data = [
            'dari' => $tgl1,
            'sampai' => $tgl2,
            'gaji' => $gaji,
        ];
        return view('gaji.tabelGaji', $data);
    }

    public function gajiSum(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        $data = [
            'dari' => $dari,
            'sampai' => $sampai,
            'gaji' => DB::select("SELECT a.nama,tbor.ttl_pengantar, tbora.ttl_admin, sum(d.qty_off) AS of, a.tgl_masuk ,b.rp_e, b.rp_m, b.rp_sp, b.g_bulanan, sum(d.qty_m) AS M, sum(d.qty_e) AS E, sum(d.qty_sp) AS Sp, d.nm_posisi, gagal_masak.point_gagal, berhasil_masak.point_berhasil, cuci.lama_cuci
            FROM tb_karyawan AS a

            LEFT JOIN tb_gaji AS b ON a.id_karyawan = b.id_karyawan LEFT JOIN tb_posisi as d ON a.id_posisi = d.id_posisi
            
            LEFT JOIN (
            SELECT c.id_karyawan,  c.status,
            if(c.status = 'M', COUNT(c.status), 0) AS qty_m,
            if(c.status = 'E', COUNT(c.status), 0) AS qty_e,
            if(c.status = 'SP', COUNT(c.status), 0) AS qty_sp,
            if(c.status = 'OFF', COUNT(c.status), 0) AS qty_off
            FROM tb_absen AS c 
            WHERE c.tgl BETWEEN '$dari' AND '$sampai'
            GROUP BY c.id_karyawan, c.status
            ) AS d ON d.id_karyawan = a.id_karyawan
            
            LEFT JOIN (
            SELECT koki, SUM(nilai_koki) as point_gagal FROM view_nilai_masak2 
            WHERE tgl >= '$dari' AND tgl <= '$sampai' AND lama_masak > 30
            GROUP BY koki
            )gagal_masak ON a.id_karyawan = gagal_masak.koki

            LEFT JOIN (
            SELECT COUNT(tbo.pengantar) AS ttl_pengantar,tbo.pengantar, tbo.admin
            FROM tb_order as tbo
            WHERE tbo.tgl BETWEEN '$dari' AND '$sampai'
            GROUP BY tbo.pengantar
            ) AS tbor ON tbor.pengantar = a.nama
        
            LEFT JOIN (
            SELECT COUNT(tboa.admin) AS ttl_admin,tboa.admin
            FROM tb_order as tboa
            WHERE tboa.tgl BETWEEN '$dari' AND '$sampai'
            GROUP BY tboa.admin
            ) AS tbora ON tbora.admin = a.nama

            LEFT JOIN (
                SELECT koki, SUM(nilai_koki) as point_berhasil FROM view_nilai_masak2 
                WHERE tgl >= '$dari' AND tgl <= '$sampai' AND lama_masak <= 30
                GROUP BY koki
            )berhasil_masak ON a.id_karyawan = berhasil_masak.koki

            LEFT JOIN(
            SELECT nm_karyawan, SUM(lama_cuci) as lama_cuci FROM view_mencuci WHERE tgl >= '$dari' AND tgl <= '$sampai' GROUP BY nm_karyawan
        ) cuci ON a.nama = cuci.nm_karyawan

            GROUP BY a.id_karyawan ORDER BY a.id_karyawan desc"),
        ];
        return view('gaji.excel', $data);
    }
    
    // public function gaji_export_new(Request $r)
    // {
    //     $tgl1 = $r->dari;
    //     $tgl2 = $r->sampai;

    //     $gaji = DB::select("SELECT a.nama, b.lama_cuci AS clear_up, c.lama_cuci AS mencuci , d.lama_cuci AS preper,
    //     e.lama_cuci AS checker, f.lama_cuci AS bar, g.lama_cuci AS chirashi
    //     FROM tb_karyawan AS a 
        
    //     LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
    //     FROM view_mencuci AS b WHERE b.id_ket = '1' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS b ON b.nm_karyawan = a.nama
        
    //     LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
    //     FROM view_mencuci AS b WHERE b.id_ket = '2' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS c ON c.nm_karyawan = a.nama
        
    //     LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
    //     FROM view_mencuci AS b WHERE b.id_ket = '4' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS d ON d.nm_karyawan = a.nama
        
    //     LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
    //     FROM view_mencuci AS b WHERE b.id_ket = '5' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS e ON e.nm_karyawan = a.nama
        
    //     LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
    //     FROM view_mencuci AS b WHERE b.id_ket = '6' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS f ON f.nm_karyawan = a.nama
        
    //     LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
    //     FROM view_mencuci AS b WHERE b.id_ket = '7' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS g ON g.nm_karyawan = a.nama");


    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $spreadsheet->getActiveSheet()->setTitle('Kerja lain-lain');
    //     $sheet->getStyle('A1:D4')
    //         ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
    //     // lebar kolom
    //     $sheet->getColumnDimension('A')->setWidth(15);
    //     $sheet->getColumnDimension('B')->setWidth(20);
    //     $sheet->getColumnDimension('C')->setWidth(15);
    //     $sheet->getColumnDimension('D')->setWidth(20);
    //     $sheet->getColumnDimension('E')->setWidth(13);
    //     $sheet->getColumnDimension('F')->setWidth(13);
    //     $sheet->getColumnDimension('G')->setWidth(13);
    //     // header text
    //     $sheet
    //         ->setCellValue('A1', 'NAMA')
    //         ->setCellValue('B1', 'CLEAR UP')
    //         ->setCellValue('C1', 'MENCUCI')
    //         ->setCellValue('D1', 'PREPARE')
    //         ->setCellValue('E1', 'CHECKER')
    //         ->setCellValue('F1', 'BAR')
    //         ->setCellValue('G1', 'CHIRASHI');
    //     $kolom = 2;
    //     $i = 1;
    //     foreach ($gaji as $k) {
    //         $sheet->setCellValue('A' . $kolom, $k->nama);
    //         $sheet->setCellValue('B' . $kolom, number_format($k->clear_up ? $k->clear_up / 60 : 0, 1));
    //         $sheet->setCellValue('C' . $kolom, number_format($k->mencuci ? $k->mencuci / 60 : 0, 1));
    //         $sheet->setCellValue('D' . $kolom, number_format($k->preper ? $k->preper / 60 : 0, 1));
    //         $sheet->setCellValue('E' . $kolom, number_format($k->checker ? $k->checker / 60 : 0, 1));
    //         $sheet->setCellValue('F' . $kolom, number_format($k->bar ? $k->bar / 60 : 0, 1));
    //         $sheet->setCellValue('G' . $kolom, number_format($k->chirashi ? $k->chirashi / 60 : 0, 1));
    //         $kolom++;
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $style = [
    //         'borders' => [
    //             'alignment' => [
    //                 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //                 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    //             ],
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
    //             ],
    //         ],
    //     ];
    //     $batas = $gaji;
    //     $batas = count($batas) + 1;
    //     $sheet->getStyle('A1:G' . $batas)->applyFromArray($style);

    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="Gaji kas dll.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    //     $writer->save('php://output');
    // }
    
    public function gaji_export_new(Request $r)
    {
        $tgl1 = $r->dari;
        $tgl2 = $r->sampai;


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('Gaji');

        $sheet->getColumnDimension('A')->setWidth(3);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(13);
        $sheet->getColumnDimension('H')->setWidth(13);
        $sheet->getColumnDimension('I')->setWidth(13);
        $sheet->getColumnDimension('J')->setWidth(13);
        $sheet->getColumnDimension('K')->setWidth(13);
        $sheet->getColumnDimension('L')->setWidth(13);
        $sheet->getColumnDimension('M')->setWidth(13);
        $sheet->getColumnDimension('N')->setWidth(13);
        $sheet->getColumnDimension('O')->setWidth(13);
        $sheet->getColumnDimension('P')->setWidth(13);
        $sheet->getColumnDimension('Q')->setWidth(13);
        $sheet->getColumnDimension('R')->setWidth(13);

        $sheet
            // posisi
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'NAMA')
            ->setCellValue('C1', 'TGL MASUK')
            ->setCellValue('D1', 'POSISI')
            ->setCellValue('E1', 'TAHUN')
            ->setCellValue('F1', 'BULAN')
            ->setCellValue('G1', 'ABSEN OFF')
            ->setCellValue('H1', 'ABSEN M')
            ->setCellValue('I1', 'ABSEN E')
            ->setCellValue('J1', 'ABSEN SP')
            // ->setCellValue('K1', 'TOTAL TERIMA ORDER')
            ->setCellValue('K1', 'RP M')
            ->setCellValue('L1', 'RP E')
            ->setCellValue('M1', 'RP SP')
            ->setCellValue('N1', 'BULANAN');


        $gaji = DB::select("SELECT a.nama,tbor.ttl_pengantar, tbora.ttl_admin, sum(d.qty_off) AS of, a.tgl_masuk ,b.rp_e, b.rp_m, b.rp_sp, b.g_bulanan, sum(d.qty_m) AS M, sum(d.qty_e) AS E, sum(d.qty_sp) AS Sp, d.nm_posisi, gagal_masak.point_gagal, berhasil_masak.point_berhasil, cuci.lama_cuci
        FROM tb_karyawan AS a

        LEFT JOIN tb_gaji AS b ON a.id_karyawan = b.id_karyawan LEFT JOIN tb_posisi as d ON a.id_posisi = d.id_posisi
        
        LEFT JOIN (
        SELECT c.id_karyawan,  c.status,
        if(c.status = 'M', COUNT(c.status), 0) AS qty_m,
        if(c.status = 'E', COUNT(c.status), 0) AS qty_e,
        if(c.status = 'SP', COUNT(c.status), 0) AS qty_sp,
        if(c.status = 'OFF', COUNT(c.status), 0) AS qty_off
        FROM tb_absen AS c 
        WHERE c.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY c.id_karyawan, c.status
        ) AS d ON d.id_karyawan = a.id_karyawan
        
        LEFT JOIN (
        SELECT koki, SUM(nilai_koki) as point_gagal FROM view_nilai_masak2 
        WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND lama_masak > 30
        GROUP BY koki
        )gagal_masak ON a.id_karyawan = gagal_masak.koki

        LEFT JOIN (
        SELECT COUNT(tbo.pengantar) AS ttl_pengantar,tbo.pengantar, tbo.admin
        FROM tb_order as tbo
        WHERE tbo.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY tbo.pengantar
        ) AS tbor ON tbor.pengantar = a.nama
    
        LEFT JOIN (
        SELECT SUM(tboa.harga) AS ttl_admin,tboa.admin
        FROM tb_order as tboa
        WHERE tboa.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY tboa.admin
        ) AS tbora ON tbora.admin = a.nama

        LEFT JOIN (
            SELECT koki, SUM(nilai_koki) as point_berhasil FROM view_nilai_masak2 
            WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND lama_masak <= 30
            GROUP BY koki
        )berhasil_masak ON a.id_karyawan = berhasil_masak.koki

        LEFT JOIN(
        SELECT nm_karyawan, SUM(lama_cuci) as lama_cuci FROM view_mencuci WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' GROUP BY nm_karyawan
    ) cuci ON a.nama = cuci.nm_karyawan

        GROUP BY a.id_karyawan ORDER BY a.id_karyawan desc");
        $row = 2;
        $total = 0;
        $total_gagal = 0;
        $total_berhasil = 0;
        $total_cuci = 0;
        $no = 1;
        foreach ($gaji as $l) {
            $spreadsheet->setActiveSheetIndex(0);
            $total += $l->rp_m * $l->M + $l->rp_e * $l->E + $l->rp_sp * $l->Sp + $l->g_bulanan;
            $total_cuci += $l->lama_cuci ? $l->lama_cuci / 60 : 0;
            $totalKerja = new DateTime($l->tgl_masuk);
            $today = new DateTime();
            $tKerja = $today->diff($totalKerja);
            $sheet
                // posisi
                ->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $l->nama)
                ->setCellValue('C' . $row, $l->tgl_masuk)
                ->setCellValue('D' . $row, $l->nm_posisi)
                ->setCellValue('E' . $row, $tKerja->y)
                ->setCellValue('F' . $row, $tKerja->m)
                ->setCellValue('G' . $row, $l->of)
                ->setCellValue('H' . $row, $l->M)
                ->setCellValue('I' . $row, $l->E)
                ->setCellValue('J' . $row, $l->Sp)
                // ->setCellValue('K' . $row, $l->ttl_admin == '' ? '0' : number_format($l->ttl_admin,0))
                ->setCellValue('K' . $row, number_format($l->rp_m))
                ->setCellValue('L' . $row, number_format($l->rp_e))
                ->setCellValue('M' . $row, number_format($l->rp_sp))
                ->setCellValue('N' . $row, number_format($l->g_bulanan));

            $row++;
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

        $batas = $gaji;
        $batas = count($gaji) + 1;
        $sheet->getStyle('A1:N' . $batas)->applyFromArray($style);

        $gaji2 = DB::select("SELECT a.nama, b.lama_cuci AS clear_up, c.lama_cuci AS mencuci , d.lama_cuci AS preper,
        e.lama_cuci AS checker, f.lama_cuci AS pasar, g.lama_cuci AS kasir, h.point_berhasil, i.point_gagal, j.point_bar,k.ttl_admin,l.lama_cuci as prepare_salmon, m.lama_cuci as prepare_gyoza
        FROM tb_karyawan AS a 
        
        LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
        FROM view_mencuci AS b WHERE b.id_ket = '1' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS b ON b.nm_karyawan = a.nama
        
        LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
        FROM view_mencuci AS b WHERE b.id_ket = '2' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS c ON c.nm_karyawan = a.nama
        
        LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
        FROM view_mencuci AS b WHERE b.id_ket = '4' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS d ON d.nm_karyawan = a.nama
        
        LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
        FROM view_mencuci AS b WHERE b.id_ket = '5' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS e ON e.nm_karyawan = a.nama
        
        LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
        FROM view_mencuci AS b WHERE b.id_ket = '10' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS f ON f.nm_karyawan = a.nama
        
        LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
        FROM view_mencuci AS b WHERE b.id_ket = '7' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS g ON g.nm_karyawan = a.nama

        LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
        FROM view_mencuci AS b WHERE b.id_ket = '8' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS l ON l.nm_karyawan = a.nama

        LEFT JOIN (SELECT b.nm_karyawan , b.id_ket , SUM(b.lama_cuci) AS lama_cuci
        FROM view_mencuci AS b WHERE b.id_ket = '9' AND b.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY b.nm_karyawan ) AS m ON m.nm_karyawan = a.nama

        LEFT JOIN (
            SELECT koki, SUM(nilai_koki) as point_berhasil FROM view_nilai_masak2 
            WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND lama_masak <= 30
            GROUP BY koki
        )h ON a.id_karyawan = h.koki
        

        LEFT JOIN (
        SELECT koki, SUM(nilai_koki) as point_gagal FROM view_nilai_masak2 
        WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' AND lama_masak > 30
        GROUP BY koki
        )i ON a.id_karyawan = i.koki

        LEFT JOIN (
            SELECT koki, SUM(nilai_koki) as point_bar FROM view_bar2 
            WHERE tgl >= '$tgl1' AND tgl <= '$tgl2' 
            GROUP BY koki
        )j ON a.id_karyawan = j.koki

        LEFT JOIN (
        SELECT SUM(tboa.harga) AS ttl_admin,tboa.admin
        FROM tb_order as tboa
        WHERE tboa.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY tboa.admin
        ) AS k ON k.admin = a.nama

        order by a.tgl_masuk ASC
        ");
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);

        $sheet2 = $spreadsheet->getActiveSheet();
        $sheet2->setTitle('Kerja lain-lain');

        $spreadsheet->getActiveSheet()->getStyle('G')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        // lebar kolom
        $sheet2->getColumnDimension('A')->setWidth(3);
        $sheet2->getColumnDimension('B')->setWidth(20);
        $sheet2->getColumnDimension('C')->setWidth(15);
        $sheet2->getColumnDimension('D')->setWidth(14.36);
        $sheet2->getColumnDimension('E')->setWidth(13);
        $sheet2->getColumnDimension('F')->setWidth(13);
        $sheet2->getColumnDimension('G')->setWidth(16);
        $sheet2->getColumnDimension('J')->setWidth(13);
        $sheet2->getColumnDimension('K')->setWidth(14);
        $sheet2->getColumnDimension('L')->setWidth(14);
        // header text
        $sheet2
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'Point Masak')
            ->setCellValue('D1', 'Non Point Masak')
            ->setCellValue('E1', 'Bar')
            ->setCellValue('F1', 'Total Terima Order')
            ->setCellValue('G1', 'Clear up')
            ->setCellValue('H1', 'Mencuci')
            ->setCellValue('I1', 'Prepare')
            ->setCellValue('J1', 'Prepare Salmon')
            ->setCellValue('K1', 'Prepare Gyoza')
            ->setCellValue('L1', 'Checker')
            ->setCellValue('M1', 'Kasir')
            ->setCellValue('N1', 'Pasar');
        $ttl = 0;
        foreach ($gaji2 as $s) {
            $ttl += $s->ttl_admin;
        }
        $kolom = 2;
        $i = 1;
        foreach ($gaji2 as $k) {
            $spreadsheet->setActiveSheetIndex(1);
            $sheet2->setCellValue('A' . $kolom, $i++);
            $sheet2->setCellValue('B' . $kolom, $k->nama);
            $sheet2->setCellValue('C' . $kolom, $k->point_berhasil ? $k->point_berhasil : 0);
            $sheet2->setCellValue('D' . $kolom, $k->point_gagal ? $k->point_gagal : 0);
            $sheet2->setCellValue('E' . $kolom, number_format($k->point_bar ? $k->point_bar / 3 : 0, 1));
            // $komisi = (($ttl * 0.07) / 7);
            // $duitnya = ($komisi / $ttl) * $k->ttl_admin;
            $sheet2->setCellValue('F' . $kolom, $k->ttl_admin  ? $k->ttl_admin : 0);
            // $sheet2->setCellValue('G' . $kolom, $duitnya  ? $duitnya : 0);
            $sheet2->setCellValue('G' . $kolom, number_format($k->clear_up ? $k->clear_up / 60 : 0, 1));
            $sheet2->setCellValue('H' . $kolom, number_format($k->mencuci ? $k->mencuci / 60 : 0, 1));
            $sheet2->setCellValue('I' . $kolom, number_format($k->preper ? $k->preper / 60 : 0, 1));
            $sheet2->setCellValue('J' . $kolom, number_format($k->prepare_salmon ? $k->prepare_salmon / 60 : 0, 1));
            $sheet2->setCellValue('K' . $kolom, number_format($k->prepare_gyoza ? $k->prepare_gyoza / 60 : 0, 1));
            $sheet2->setCellValue('L' . $kolom, number_format($k->checker ? $k->checker / 60 : 0, 1));
            $sheet2->setCellValue('M' . $kolom, number_format($k->kasir ? $k->kasir / 60 : 0, 1));
            $sheet2->setCellValue('N' . $kolom, number_format($k->pasar ? $k->pasar / 60 : 0, 1));
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
        $batas = $gaji2;
        $batas = count($batas) + 1;
        $sheet2->getStyle('A1:N' . $batas)->applyFromArray($style);
        // end -----------------------------------------------------------------
        
        // sheet absen ----------------------------------------------------------
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(2);
        $sheet3 = $spreadsheet->getActiveSheet();
        $sheet3->setTitle('Absen');
        $spreadsheet->getActiveSheet()->getStyle('C1:AK1')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet3->getStyle('C1:AK1')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        // lebar kolom
        $sheet3->getColumnDimension('A')->setWidth(10);
        $sheet3->getColumnDimension('B')->setWidth(20);
        
        $char = range('C', 'Z');
        foreach($char as $h) {
            $sheet3->getColumnDimension("$h")->setWidth(10);
        }
        $charG = range('A', 'G');
        foreach ($charG as $h) {
            $sheet3->getColumnDimension("A$h")->setWidth(10);
        }

        $g= 1;
        $sheet3->setCellValue('A1', 'NO');
        $sheet3->setCellValue('B1', 'NAMA');
        foreach($char as $n) {
            $sheet3->setCellValue("$n".'1',$g++);
            
        }
        $g1= $g;
        $charG = range('A', 'G');
        foreach ($charG as $h) {
            $sheet3->setCellValue("A$h".'1',$g1++);
        }
        // 
        $sheet3->getColumnDimension("AH")->setWidth(15);
        $sheet3->setCellValue('AH1', 'Total Off');
        $sheet3->getColumnDimension("AI")->setWidth(15);
        $sheet3->setCellValue('AI1', 'Total M');
        $sheet3->getColumnDimension("Aj")->setWidth(15);
        $sheet3->setCellValue('Aj1', 'Total E');
        $sheet3->getColumnDimension("Ak")->setWidth(15);
        $sheet3->setCellValue('Ak1', 'Total Sp');
        
        $abs = DB::select("SELECT  a.nama,b.status,b.tgl
                                FROM tb_karyawan as a
                                LEFT JOIN tb_absen AS b ON  a.id_karyawan = b.id_karyawan
                                WHERE b.tgl BETWEEN '2022-03-01' AND '2022-03-08';");
        $karyawan = Karyawan::all();
        $nom = 1;
        $kolom = 2;
        
        foreach($karyawan as $k){
            $totalOff = 0;
            $totalM = 0;
            $totalE = 0;
            $totalSP = 0;
                    
            $sheet3->setCellValue("A".$kolom,$nom++);
            $sheet3->setCellValue("B".$kolom,$k->nama);
            $field = range('C', 'Z');
            $t = 1;
            foreach($field as $n) {
                $absen = DB::table('tb_absen')
                                ->select('tb_absen.*')
                                ->where('id_karyawan', '=', $k->id_karyawan)
                                ->where('tgl', '=', Str::substr($tgl1,0,8).$t)
                                ->first();
                // dd($absen);
                if($absen) {
                    $sheet3->setCellValue("$n".$kolom,$absen->status);
                    if($absen->status == 'M') {
                        $totalM++;
                    } elseif($absen->status == 'E') {
                        $totalE++;
                    } elseif($absen->status == 'SP') {
                        $totalSP++;
                    } else {
                        $totalOff++;
                    }
                } else {
                    $sheet3->setCellValue("$n".$kolom,'');
                }
                $t++;
                
            }
            $t1= $t;
            $field2 = range('A', 'G');
            foreach ($field2 as $h) {
                $absen = DB::table('tb_absen')
                                ->select('tb_absen.*')
                                ->where('id_karyawan', '=', $k->id_karyawan)
                                ->where('tgl', '=', Str::substr($tgl1,0,8).$t1)
                                ->first();
                // dd($t);
                if($absen) {
                    $sheet3->setCellValue("A$h".$kolom,$absen->status);
                    if($absen->status == 'M') {
                        $totalM++;
                    } elseif($absen->status == 'E') {
                        $totalE++;
                    } elseif($absen->status == 'SP') {
                        $totalSP++;
                    } else {
                        $totalOff++;
                    }
                } else {
                    $sheet3->setCellValue("A$h".$kolom,'');
                }
                $t1++;
            }
            
            $sheet3->setCellValue("AH".$kolom,$totalOff);
            $sheet3->setCellValue("AI".$kolom,$totalM);
            $sheet3->setCellValue("AJ".$kolom,$totalE);
            $sheet3->setCellValue("AK".$kolom,$totalSP);
            
            $kolom++;
            
        }
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
        $batas = $karyawan;
        $batas = count($batas) + 1;
        $sheet3->getStyle('A1:AK' . $batas)->applyFromArray($style);
        $spreadsheet->getActiveSheet()->getStyle('A1:AK'.$batas)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Gaji Resto TS.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
