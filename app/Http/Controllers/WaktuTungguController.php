<?php

namespace App\Http\Controllers;

use App\Models\Peringatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WaktuTungguController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 19)->first();
        if(empty($id_menu)) {
            return back();
        } else {
            $id_lokasi = $request->session()->get('id_lokasi');
            $data = [
                'title' => 'Waktu Tunggu',
                'logout' => $request->session()->get('logout'),
                'peringatan' => Peringatan::where('id_lokasi', $id_lokasi)
                                ->where('tgl', date('Y-m-d'))
                                ->get(),
                'cek'        => Peringatan::where('id_lokasi', $id_lokasi)
                                ->where('tgl', date('Y-m-d'))
                                ->where('jam_buat', '<=', date('H:i:s'))
                                ->where('jam_akhir', '>=', date('H:i:s'))
                                ->first(),
            ];
    
            return view('waktuTunggu.waktuTunggu', $data);
        }
    }

    public function addWaktuTunggu(Request $request)
    {
        date_default_timezone_set('Asia/Makassar');
        $loc = $request->session()->get('id_lokasi');
        $time = date_create(date('Y-m-d H:i:s'));
        date_add($time, date_interval_create_from_date_string($request->batas.' minutes'));
        $data = [
            'id_lokasi' => $loc,
            'jam_buat' => date('H:i:s'),
            'jam_akhir' => date_format($time, 'H:i:s') ,
            'tgl' => date('Y-m-d'),
            'admin' => Auth::user()->nama
        ];

        Peringatan::create($data);

        return redirect()->route('waktuTunggu')->with('success', 'Waktu tunggu berhasil dibuat');
    }

    public function get_peringatan(Request $request)
    {
        date_default_timezone_set('Asia/Makassar');
        $id_lokasi = $request->session()->get('id_lokasi');
        $peringatan = 
        Peringatan::where([
                        ['id_lokasi', $id_lokasi],
                        ['tgl', date('Y-m-d')],
                        ['jam_buat', '<=', date('H:i:s')],
                        ['jam_akhir', '>=', date('H:i:s')],
                    ])->first();
                    // Peringatan::where('id_lokasi', $id_lokasi)->where('tgl', date('Y-m-d'))->where('jam_buat', '<=', date('H:i:s'))->where('jam_akhir', '<=', date('H:i:s'))->first();
        // dd($peringatan->jam_akhir);
        if($peringatan){
            $waktu_awal  = strtotime(date('Y-m-d H:i:s'));
            $waktu_akhir = strtotime(date('Y-m-d ').$peringatan->jam_akhir);
            $diff = $waktu_akhir - $waktu_awal;
            $menit    =floor($diff /  60);
            echo'<div id="blink" class="alert alert-info text-center" role="alert">
        Waktu tunggu <strong>'.$menit.'menit</strong>
        </div>';
        }else{
            echo'';
        }
    }

    public function hapusWaktuTunggu(Request $request)
    {
        Peringatan::where('id_peringatan', $request->id_peringatan)->delete();
        return redirect()->route('waktuTunggu')->with('error', 'Data berhasil dihapus');
    }
}
