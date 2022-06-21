<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Ket;
use App\Models\Mencuci;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MencuciController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 5)->first();
        if(empty($id_menu)) {
            return back();
        } else {
            if (empty($request->tgl1)) {
                $tgl1 = date('Y-m-01');
                $tgl2 = date('Y-m-d');
            } else {
                $tgl1 = $request->tgl1;
                $tgl2 = $request->tgl2;
            }
            $tglhariIni = date('Y-m-d');
            $mencuci = DB::select("SELECT * from tb_mencuci as a left join keterangan_cuci as b on a.id_ket = b.id_ket where a.tgl between '$tgl1' and '$tgl2' order by a.id_mencuci DESC ");
            $data = [
                'title' => 'Data Mencuci',
                'logout' => $request->session()->get('logout'),
                'mencuci' => $mencuci,
                'ket' => Ket::all(),
                'karyawan' => Karyawan::join('tb_absen', 'tb_karyawan.id_karyawan', '=', 'tb_absen.id_karyawan')->where('tb_absen.tgl', $tglhariIni)->where('tb_absen.id_lokasi', $request->session()->get('id_lokasi'))->get(),
            ];
    
            return view('mencuci.mencuci', $data);
        }
    }
    public function addMencuci(Request $request)
    {   
        $nama = $request->nama;
        $ket = $request->ket;
        $j_awal = $request->j_awal;
        $j_akhir = $request->j_akhir;
        $tgl = $request->tgl;
        $ket2 = $request->ket2;

        for ($i=0; $i < count($request->nama); $i++) { 
            $data = [
                'nm_karyawan' => $nama[$i],
                'id_ket' => $ket[$i],
                'ket2' => $ket2[$i],
                'tgl' => $tgl[$i],
                'j_awal' => $j_awal[$i],
                'j_akhir' => $j_akhir[$i],
                'admin' => Auth::user()->nama
            ];
            Mencuci::create($data);
        }


        return redirect()->route('mencuci')->with('sukses', 'Berhasil tambah mencuci');
    }     

    public function editMencuci(Request $request)
    {
        $data = [
            'nm_karyawan' => $request->nama,
            'id_ket' => $request->ket,
            'ket2' => $request->ket2,
            'tgl' => $request->tgl,
            'j_awal' => $request->j_awal,
            'j_akhir' => $request->j_akhir,
            'admin' => Auth::user()->nama
        ];

    
        Mencuci::where('id_mencuci',$request->id_mencuci)->update($data);

      
        return redirect()->route('mencuci')->with('sukses', 'Berhasil Ubah Data mencuci');
    }

    public function deleteMencuci(Request $request)
    {
        Mencuci::where('id_mencuci',$request->id_mencuci)->delete();
        return redirect()->route('mencuci')->with('error', 'Berhasil hapus mencuci');
    }
     
}
