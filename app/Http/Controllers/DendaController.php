<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DendaController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 7)->first();
        if (empty($id_menu)) {
            return back();
        } else {

            $data = [
                'title' => 'Data Denda',
                'logout' => $request->session()->get('logout'),
                'denda' => Denda::orderBy('id_denda', 'desc')->get(),
                'karyawan' => Karyawan::all(),
                'jenis' => 'all'
            ];

            return view('denda.denda', $data);
        }
    }

    public function addDenda(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'alasan' => $request->alasan,
            'nominal' => $request->nominal,
            'tgl' => $request->tgl,
            'id_lokasi' => $request->session()->get('id_lokasi'),
            'admin' => Auth::user()->nama
        ];

        Denda::create($data);

        return redirect()->route('denda')->with('sukses', 'Berhasil tambah denda');
    }

    public function editDenda(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'alasan' => $request->alasan,
            'nominal' => $request->nominal,
            'tgl' => $request->tgl,
            'id_lokasi' => $request->session()->get('id_lokasi'),
            'admin' => Auth::user()->nama
        ];

        Denda::where('id_denda', $request->id_denda)->update($data);


        return redirect()->route('denda')->with('sukses', 'Berhasil Ubah Data denda');
    }

    public function deleteDenda(Request $request)
    {
        Denda::where('id_denda', $request->id_denda)->delete();
        return redirect()->route('denda')->with('error', 'Berhasil hapus denda');
    }

    public function printDenda(Request $request)
    {
        $tglDari = $request->dari;
        $tglSampai = $request->sampai;
        if (empty($tglDari)) {
            $dari = date('Y-m-1');
            $sampai = date('Y-m-d');
        } else {
            $dari = $tglDari;
            $sampai = $tglSampai;
        }

        $data = [
            'title' => 'Denda print',

            'date' => date('m/d/Y'),
            'denda' => DB::select("SELECT *, sum(a.nominal) as total FROM tb_denda as a WHERE `tgl` BETWEEN '$dari' and '$sampai' group by a.nama"),
            'karyawan' => Karyawan::all(),
            'alasan' => Denda::all()
        ];

        return view('denda.pdf', $data);
    }
    public function printDendaPerorang(Request $request)
    {
        $tglDari = $request->dari;
        $tglSampai = $request->sampai;
        // $nama = $request->nama;
        $id_karyawan = $request->id_karyawan;
        // dd($id_karyawan);
        if ($id_karyawan[0] == '0') {
            if (empty($tglDari)) {
                $dari = date('Y-m-1');
                $sampai = date('Y-m-d');
            } else {
                $dari = $tglDari;
                $sampai = $tglSampai;
            }

            $data = [
                'title' => 'Denda print',

                'date' => date('m/d/Y'),
                'denda' => DB::select("SELECT *, sum(a.nominal) as total FROM tb_denda as a WHERE `tgl` BETWEEN '$dari' and '$sampai' group by a.nama"),
                'karyawan' => Karyawan::all(),
                'alasan' => Denda::all(),
                'dari' => $dari,
                'sampai' => $sampai,
            ];

            return view('denda.excel', $data);
        } else {
            if (empty($tglDari)) {
                $dari = date('Y-m-1');
                $sampai = date('Y-m-d');
            } else {
                $dari = $tglDari;
                $sampai = $tglSampai;
            }
            // $idk = [$id_karyawan];
            // foreach ($id_karyawan as $ik => $i) {
            // }
            // $ar = array_column($idk, $ik);
            // dd($ar);
            $denda = Denda::whereBetween('tgl', [$dari, $sampai])->whereIn('nama', $id_karyawan)->orderBy('nama')->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(20);

            $sheet->setCellValue('A1', 'NO')
                ->setCellValue('B1', 'NAMA')
                ->setCellValue('C1', 'ALASAN')
                ->setCellValue('D1', 'NOMINAL')
                ->setCellValue('E1', 'TANGGAL');
            $row = 2;
            $rowAl = 2;
            $no = 1;
            $namaAda = '';
            foreach ($denda as $l) {
                $sheet->setCellValue('A' . $row, $no++)
                    ->setCellValue('B' . $row, $l->nama == $namaAda ? '' : $l->nama)
                    ->setCellValue('C' . $row, $l->alasan)
                    ->setCellValue('D' . $row, $l->nominal)
                    ->setCellValue('E' . $row, $l->tgl);
                // $alasan = Denda::where('nama', $l->nama)->get();
                // if($alasan) {
                //     foreach($alasan as $a) {
               
                //         $sheet->setCellValue('C' . $rowAl, $a->alasan)
                //         ->setCellValue('D' . $rowAl, $a->nominal)
                //         ->setCellValue('E' . $rowAl, $a->tgl);
                //         $rowAl++; 
                        
                //     }
                // } else {
                //     continue;
                // }
                
                $row++; 
                $namaAda = $l->nama;
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

            $batas = $denda;
            $batas = count($denda) + 1;
            $sheet->getStyle('A1:E' . $batas)->applyFromArray($style);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Denda Perorang.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }
    }
}
