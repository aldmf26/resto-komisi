<?php

namespace App\Http\Controllers;

use App\Models\SetOrang;
use App\Models\Persentase_kom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetOrangController extends Controller
{
    public function index(Request $request) 
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 240)->first();
        if(empty($id_menu)) {
            return back();
        } else {
            $id_lokasi = $request->get('id_lokasi') == '' ? 1 : $request->get('id_lokasi');

            $lokasi = $id_lokasi == 1 ? 'TAKEMORI' : 'SOONDOBU';
            $data = [
                'title' => 'Setting Jumlah Orang',
                'id_lokasi' => $id_lokasi,
                'logout' => $request->session()->get('logout'),
                'jumlahOrang' => SetOrang::where('id_lokasi', $id_lokasi)->orderBy('id_orang', 'desc')->get(),
                'persen' => Persentase_kom::where('id_lokasi', $id_lokasi)->orderBy('id_persentase', 'ASC')->get(),
            ];
    
            return view('jumlahOrang.jumlahOrang', $data);
        }
    }
    
    public function edit(Request $request)
    {
        $id_lokasi = $request->id_lokasi;
        SetOrang::where('id_orang',$request->id_orang)->update(['ket_karyawan' => $request->ket,'jumlah' => $request->jumlah]);
        return redirect()->route('setOrang', ['id_lokasi' => $id_lokasi])->with('success', 'Berhasil ubah setting jumlah orang');
    }
    public function edit_persen(Request $request)
    {
        $id_lokasi = $request->id_lokasi;
        Persentase_kom::where('id_persentase',$request->id_persentase)->update(['jumlah_persen' => $request->jumlah_persen]);
        return redirect()->route('setOrang', ['id_lokasi' => $id_lokasi])->with('success', 'Berhasil ubah data persentase');
    }
}