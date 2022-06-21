<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Posisi;
use App\Models\Sub_navbar;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 24)->first();
        if (empty($id_menu)) {
            return back();
        } else {
            if (Auth::user()->jenis == 'adm') {
                if (empty($request->jenis)) {
                    $jenis = 'adm';
                } else {
                    $jenis = $request->jenis;
                }
                $data = [
                    'title' => 'Users',
                    'logout' => $request->session()->get('logout'),
                    'users' => Users::where('jenis', $jenis)->get(),
                    'navbar' => DB::table('tb_sub_navbar')->orderBy('urutan', 'ASC')->get(),
                    'jenis' => $jenis,
                    'tb_posisi' => Posisi::all(),
                ];

                return view("users.users", $data);
            } else {
                return back();
            }
        }
    }
    
    public function editUsers(Request $request) {
        Users::where('id',$request->id)->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);
        
        return redirect()->route('users', ['jenis' => $request->jenis])->with('sukses', 'Berhasil mengubah Data');
    }

    public function addUsers(Request $request)
    {
        $posisi = $request->posisi;
        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'jenis' => $request->jenis,
            'id_posisi' => $posisi,
        ];
        $id = Users::create($data);
        $menu = DB::table('tb_sub_navbar')->get();
        if($posisi == 1) {
            $id_user = $id->id;
            $id_menu = [1,2,3,4,5,6,7,8,9,11,12,13,14,15,16,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
            foreach($id_menu as $m) {
         
                $data = [
                    'id_menu' => $m,
                    'id_user' => $id_user,
                    'lokasi' => $request->jenis,
                ];
                Permission::create($data);
            }
            
        }
        
        if($posisi == 5) {
            $id_user = $id->id;
            $id_menu = [3,4,5,7,8,25,26,27,28,29,30];
            foreach($id_menu as $m) {
         
                $data = [
                    'id_menu' => $m,
                    'id_user' => $id_user,
                    'lokasi' => $request->jenis,
                ];
                Permission::create($data);
            }
            
        }
        
        if($posisi == 2) {
            $id_user = $id->id;
            $id_menu = [1,2,3,4,5,7,8,9,11,12,13,14,15,18,19,20,21,22,24,25,26,27,28,29,30,31];
            foreach($id_menu as $m) {
         
                $data = [
                    'id_menu' => $m,
                    'id_user' => $id_user,
                    'lokasi' => $request->jenis,
                ];
                Permission::create($data);
            }
            
        }

        return redirect()->route('users', ['jenis' => $request->jenis])->with('sukses', 'Berhasil Menambahkan Data');
    }

    public function permission(Request $request)
    {
        // dd($request->menu);
        Permission::where('id_user', $request->id_user)->delete();
        $id_user = $request->id_user;
        $lokasi = $request->lokasi;
        foreach ($request->menu as $key => $d) {
            $data = [
                'id_menu' => $d,
                'id_user' => $id_user,
                'lokasi'  =>  $lokasi
            ];
            Permission::create($data);
        }

        return redirect()->route('users', ['jenis' => $request->lokasi]);
    }

    public function editUrutan(Request $request)
    {
        $urutan = $request->urutan;

        $id_sub_navbar = $request->id_sub_navbar;
        for ($i = 0; $i < count($id_sub_navbar); $i++) {

            $data = [
                'urutan' => $urutan[$i],
            ];
            Sub_navbar::where('id_sub_navbar', $id_sub_navbar[$i])->update($data);
        }

        return redirect()->route('users', ['jenis' => $request->jenis]);
    }

    public function adminMenu(Request $request)
    {
        $data = [
            'navbar' => DB::table('tb_sub_navbar')->orderBy('urutan', 'ASC')->get(),
            'jenis' => $request->jenis,
            'database' => DB::table('tb_sub_navbar')
                ->where('id_navbar', 4)
                ->orderBy('urutan')
                ->get(),
            'resto' => DB::table('tb_sub_navbar')
                ->where('jen', 1)
                ->whereNotIn('id_navbar', [3, 5])
                ->orderBy('urutan')
                ->get(),
            'catatan' => DB::table('tb_sub_navbar')
                ->where('id_navbar', 3)
                ->orderBy('urutan')
                ->get(),
            'peringatan' => DB::table('tb_sub_navbar')
                ->where('id_navbar', 5)
                ->orderBy('urutan')
                ->get(),
        ];
        return view('users.adminMenu', $data);
    }

    public function restoMenu(Request $request)
    {
        $data = [
            'navbar' => DB::table('tb_sub_navbar')->orderBy('urutan', 'ASC')->get(),
            'jenis' => $request->jenis,
            'database' => DB::table('tb_sub_navbar')
                ->where('id_navbar', 4)
                ->orderBy('urutan')
                ->get(),
            'resto' => DB::table('tb_sub_navbar')
                ->where('jen', 1)
                ->whereNotIn('id_navbar', [3, 5])
                ->orderBy('urutan')
                ->get(),
            'catatan' => DB::table('tb_sub_navbar')
                ->where('id_navbar', 3)
                ->orderBy('urutan')
                ->get(),
            'peringatan' => DB::table('tb_sub_navbar')
                ->where('id_navbar', 5)
                ->orderBy('urutan')
                ->get(),
        ];
        return view('users.restoMenu', $data);
    }

    public function importPermission(Request $request)
    {
        $nama = $request->nama_user;
        $accounting = DB::table('tb_sub_navbar')
        ->where('id_sub_navbar', 21)
        ->get();
        $gaji = DB::table('tb_sub_navbar')
        ->where('id_sub_navbar', 22)
        ->get();

        $database = DB::table('tb_sub_navbar')
            ->where('id_navbar', 4)
            ->orderBy('urutan')
            ->get();
        $resto = DB::table('tb_sub_navbar')
            ->where('jen', 1)
            ->whereNotIn('id_navbar', [3, 5])
            ->orderBy('urutan')

            ->get();
        $catatan = DB::table('tb_sub_navbar')
            ->where('id_navbar', 3)
            ->orderBy('urutan')
            ->get();
        $peringatan = DB::table('tb_sub_navbar')
            ->where('id_navbar', 5)
            ->orderBy('urutan')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            $sheet->getStyle('A1')
            ->getFont('bold');
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getStyle('B1')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet
            ->setCellValue('A1', 'JENIS');
        $sheet
            ->setCellValue('B1', 'PERMISSION');
        
        $sheet->setCellValue('A2', 'Administrator');
        $sheet->setCellValue('B2', 'Accounting');
        $sheet->setCellValue('B3', 'Gaji');
        $sheet->setCellValue('A4', 'Database');
        $kolom = 4;
        foreach ($database as $n) {
            $sheet->setCellValue('B' . $kolom, $n->sub_navbar);
            $kolom++;
            $total = $kolom;
        }
        $sheet->setCellValue('A12', 'Resto');
        foreach ($resto as $r) {
            $sheet->setCellValue('B' . $total, $r->sub_navbar);
            $total++;
            $total = $total;
        }
        $sheet->setCellValue('A19', 'Catatan');
        foreach ($catatan as $r) {
            $sheet->setCellValue('B' . $total, $r->sub_navbar);
            $total++;
            $total = $total;
        }
        $sheet->setCellValue('A25', 'Peringatan');
        foreach ($peringatan as $r) {
            $sheet->setCellValue('B' . $total, $r->sub_navbar);
            $total++;
            $total = $total;
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
        // $batas = $gaji;
        $batas = 27;
        $sheet->getStyle('A1:B' . $batas)->applyFromArray($style);
        

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="tes.xlsx"');
        header('Cache-Control: max-age=0');


        $spreadsheet->createSheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            $sheet->getStyle('A1')
            ->getFont('bold');
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getStyle('B1')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet
            ->setCellValue('A1', 'NAMA');
        $sheet
            ->setCellValue('B1', 'PERMISSION');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
