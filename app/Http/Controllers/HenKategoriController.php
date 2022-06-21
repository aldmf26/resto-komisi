<?php

namespace App\Http\Controllers;

use App\Models\Dp;
use App\Models\Handicap;
use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class HenKategoriController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 239)->first();
        if(empty($id_menu)) {
            return back();
        } else {
            $id_lokasi = $request->id_lokasi == '' ? 1 : $request->id_lokasi;
            $lokasi = $id_lokasi == 1 ? 'TAKEMORI' : 'SOONDOBU';
            
            $data = [
                'title' => 'Level Point',
                'id_lokasi' => $id_lokasi,
                'logout' => $request->session()->get('logout'),
                'kategori' => Kategori::where('lokasi', $lokasi)->orderBy('kd_kategori', 'desc')->get(),
                'handicap' => Handicap::where('id_lokasi', $id_lokasi)->orderBy('id_handicap', 'desc')->get()
            ];
    
            return view('henKategori.henKategori',$data);
        }
        
    }

    public function edit(Request $request)
    {
        $id_lokasi = $request->id_lokasi;
        Handicap::where('id_handicap',$request->id_handicap)->update(['point' => $request->point,'handicap' => $request->handicap,'ket' => $request->ket]);
        return redirect()->route('henKategori', ['id_lokasi' => $id_lokasi])->with('success', 'Berhasil ubah point');
    }

    public function tbhHenKategori(Request $request)
    {
        $id_lokasi = $request->id_lokasi == '' ? 1 : $request->id_lokasi;
        // dd($id_lokasi);
        $data = [
            'handicap' => $request->handicap,
            'point' => $request->point,
            'ket' => $request->ket,
            'id_lokasi' => $id_lokasi,
        ];
        Handicap::create($data);
        return redirect()->route('henKategori', ['id_lokasi' => $id_lokasi])->with('success', 'Berhasil tambah Handicap');
    }
    
    public function hapus(Request $request)
    {
        Handicap::where('id_handicap',$request->id_handicap)->delete();
        return redirect()->route('henKategori', ['id_lokasi' => $request->id_lokasi])->with('success', 'Berhasil tambah Handicap');
    }
    
    public function exportMenuLevel(Request $request)
    {
        $id_lokasi = $request->lokasi;
        $lokasiTs = $id_lokasi == 1 ? 'TAKEMORI' : 'SOONDOBU';
        
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
        // header text
        $sheet
            ->setCellValue('A1', 'KATEGORI')
            ->setCellValue('B1', 'ID MENU')
            ->setCellValue('C1', 'NAMA MENU')
            ->setCellValue('D1', 'TIPE(FOOD/DRINK)')
            ->setCellValue('E1', 'ID LEVEL')
            ->setCellValue('F1', 'POINT');

        $sheet
            ->setCellValue('H1', 'Level Point')
            ->setCellValue('I1', 'Id Level')
            ->setCellValue('J1', 'Level')
            ->setCellValue('K1', 'Point')
            ->setCellValue('L1', 'Keterangan');
        $level = DB::table('tb_handicap')->where('id_lokasi', $id_lokasi)->get();
        $tbMenu = DB::table('mHandicap')->where('lokasiMenu', $id_lokasi)->orderBy('id_menu', 'DESC')
                        ->get();
        $lom = 2;
        foreach($tbMenu as $t) {
            $sheet
                ->setCellValue('A'.$lom,$t->kategori)
                ->setCellValue('B'.$lom,$t->id_menu)
                ->setCellValue('C'.$lom,$t->nm_menu)
                ->setCellValue('D'.$lom,$t->tipe)
                ->setCellValue('E'.$lom,$t->id_handicap)
                ->setCellValue('F'.$lom,$t->point);
                
            $lom++;
        }
        $kolom = 2;
        foreach ($level as $k) {
            $sheet
                ->setCellValue('I'.$kolom,$k->id_handicap)
                ->setCellValue('J'.$kolom,$k->handicap)
                ->setCellValue('K'.$kolom,$k->point)
                ->setCellValue('L'.$kolom,$k->ket);
            $kolom++;
        }

        $writer = new Xlsx($spreadsheet);
        $style = [
            'borders' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];

        // tambah style
        $batas1 = count($tbMenu) + 1;
        $sheet->getStyle('A1:F'.$batas1)->applyFromArray($style);
        $batas = count($level) + 1;
        $sheet->getStyle('I1:L'.$batas)->applyFromArray($style);
        
        // center
        $sheet->getStyle('I1')->getAlignment()->setHorizontal('center');
        // $sheet->getStyle('M1')->getAlignment()->setHorizontal('center');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Format Level Menu '.$lokasiTs.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
    
    public function importMenuLevel(Request $request)
    {
            // include APPPATH.'third_party/PHPExcel/PHPExcel.php';
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($file);
            // $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
            // $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $lokasi = $request->id_lokasi;
    
    
            $data = array();
            $numrow = 1;
            // cek
            $cek = 0;
            foreach ($sheet as $row) {
    
                if ($row['A'] == "" && $row['B'] == "" && $row['C'] == "" && $row['D'] == "" && $row['E'] == "" && $row['F'] == "")
                    continue;
                $numrow++; // Tambah 1 setiap kali looping
            }
            // endcek
        
            
            $kmenu = Menu::orderBy('kd_menu', 'desc')->where('lokasi', $lokasi)->first();

            $kd_menu = $kmenu->kd_menu + 1;

            foreach ($sheet as $row) {
    
                if ($numrow > 1) {
                    
                    $data = [
                        'id_handicap' => $row['E']
                    ];
                    Menu::where('id_menu', $row['B'])->update($data);
                    
                    if($row['I'] == '' && $row['J'] == '' && $row['K'] == '') {
                        continue;
                    } elseif($row['I'] == '') {
                        $data = [
                            'handicap' => $row['J'],
                            'point' => $row['K'],
                            'id_lokasi' => $request->lokasi,
                        ];
                        Handicap::create($data);
                    } else {
                        $data = [
                            'handicap' => $row['J'],
                            'point' => $row['K'],
                        ];
                        Handicap::where('id_handicap', $row['I'])->update($data);
                    }
                }
                $numrow++; // Tambah 1 setiap kali looping
            }
    
            return redirect()->route('menu', ['id_lokasi' => 1])->with('sukses', 'Data berhasil Diimport');

        
    }
}
