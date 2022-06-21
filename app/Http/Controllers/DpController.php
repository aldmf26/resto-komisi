<?php

namespace App\Http\Controllers;

use App\Models\Dp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DpController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 8)->first();
        if(empty($id_menu)) {
            return back();
        } else {
            $data = [
                'title' => 'DP',
                'logout' => $request->session()->get('logout'),
                'dp' => Dp::where('id_lokasi', $request->session()->get('id_lokasi'))->orderBy('id_dp', 'desc')->get(),
            ];
    
            return view('dp.dp', $data);
        }
    }

    public function addDp(Request $request)
    {
        $id_lokasi = $request->session()->get('id_lokasi');
        if($id_lokasi == 1) {
            $c = 'TKMRDP';
            $kd_dp = $c . rand(10,1000);
        } else {
            $c = 'SDBDP';
            $kd_dp = $c . rand(10,1000);
        }
       
        $data = [
            'kd_dp' => $kd_dp,
            'nm_customer' => $request->nm_customer,
            'jumlah' => $request->jumlah,
            'server' => Auth::user()->nama,
            'tgl' => $request->tgl,
            'ket' => $request->ket,
            'metode' => $request->metode,
            'tgl_input' => date('Y-m-d'),
            'status' => $request->status,
            'id_lokasi' => $id_lokasi,
        ];

        Dp::create($data);
        return redirect()->route('dp')->with('sukses', 'Tambah Dp Sukses');
    }
}
