<?php

namespace App\Http\Controllers;

use App\Exports\KaryawanExport;
use App\Imports\KaryawanImport;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class AdministratorController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => 'Administrator',
            'logout' => $request->session()->get('logout'),
            'karyawan' => 
            Karyawan::select('tb_karyawan.*','tb_status.nm_status','tb_posisi.nm_posisi')->join('tb_status', 'tb_karyawan.id_status', '=', 'tb_status.id_status')->join('tb_posisi', 'tb_karyawan.id_posisi', '=', 'tb_posisi.id_posisi')->orderBy('id_karyawan', 'desc')->get(),
            'status' => DB::table('tb_status')->get(),
            'posisi' => DB::table('tb_posisi')->get(),
        ];
        return view("administrator.administrator",$data);
    }

    public function addAdministrator(Request $request)
    {   
        $data = [
            'nama' => $request->nama,
            'id_status' => $request->status,
            'id_posisi' => $request->posisi,
            'tgl_masuk' => $request->tgl_masuk,
        ];

        Karyawan::create($data);

        return redirect()->route('administrator')->with('sukses', 'Berhasil tambah karyawan');
    }

    public function editAdministrator(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'id_status' => $request->status,
            'id_posisi' => $request->posisi,
            'tgl_masuk' => $request->tgl_masuk
        ];
    
        Karyawan::where('id_karyawan',$request->id_karyawan)->update($data);

      
        return redirect()->route('administrator')->with('sukses', 'Berhasil Ubah Data Karyawan');
    }

    public function deleteAdministrator(Request $request)
    {
        Karyawan::where('id_karyawan',$request->id_karyawan)->delete();
        return redirect()->route('administrator')->with('error', 'Berhasil hapus karyawan');
    }

    public function karyawanExport()
    {
        return Excel::download(new KaryawanExport, 'karyawan.xlsx');
    }

    public function karyawanImport(Request $request)
    {
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();

        if($ext == 'xls') {
            $render = new Xls();
        } else {
            $render = new Xlsx();
        }

        $data = $render->load($file);
        $d = $data->getActiveSheet()->toArray();
        
        foreach($d as $x => $excel)
        {
            $datas = [
                'nama' => $excel[1],
                'id_status' => $excel[2],
                'id_posisi' => $excel[3],
                'tgl_masuk' => date("Y-m-d", strtotime($excel[4])),
            ];
            Karyawan::create($datas);
            
        }
        // Excel::import(new KaryawanImport, request()->file('file'));

        return redirect()->route('administrator')->with('sukses', 'Berhasil import karyawan');
    }
}
