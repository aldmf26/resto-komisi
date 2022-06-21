<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Koki;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddKokiController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 2)->first();
        if(empty($id_menu)) {
            return back();
        } else {
            $tglhariIni = date('Y-m-d');
            $idkok = Koki::where('tgl', date('Y-m-d'))->get();
            $idk = [];
            foreach($idkok as $id) {
                $idk[] = $id->id_karyawan;
            }
            
            
            $data = [
                'title' => 'Add Koki',
                'logout' => $request->session()->get('logout'),
                'karyawan' => Karyawan::where('id_status', '1')->join('tb_absen', 'tb_karyawan.id_karyawan', '=', 'tb_absen.id_karyawan')->where('tb_absen.tgl', $tglhariIni)->whereNotIn('tb_absen.id_karyawan', $idk)->where('tb_absen.id_lokasi', $request->session()->get('id_lokasi'))->get(),
                'koki' => Koki::join('tb_karyawan', 'tb_koki.id_karyawan', '=','tb_karyawan.id_karyawan')->where('tb_koki.id_lokasi', $request->session()->get('id_lokasi'))->get(),
            ];
    
            return view('addKoki.addKoki',$data);
        }
    }

    public function absenKoki(Request $request)
    {
        $id_karyawan = $request->id_karyawan;
        for ($i=0; $i < count($id_karyawan); $i++) { 
            $data = [
                'id_karyawan' => $id_karyawan[$i],
                'tgl' => date('Y-m-d'),
                'status' => 1,
                'id_lokasi' => $request->session()->get('id_lokasi'),
            ];
    
            Koki::create($data);
        }
        return redirect()->route('addKoki');
    }

    public function delAbsKoki(Request $request)
    {
        Koki::where('id_koki', $request->id_koki)->delete();
        return redirect()->route('addKoki');
    }
}
