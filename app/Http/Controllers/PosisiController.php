<?php

namespace App\Http\Controllers;

use App\Models\Posisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosisiController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 15)->first();
        if(empty($id_menu)) {
            return back();
        } else {
            if(Auth::user()->jenis == 'adm') {
                $data = [
                    'title' => 'Posisi',
                    'logout' => $request->session()->get('logout'),
                    'posisi' => Posisi::orderBy('id_posisi', 'desc')->get(),
                ];
                return view("posisi.posisi",$data);
            } else {
                return back();
            }
            
        }
    }

    public function addPosisi(Request $request)
    {   
        $data = [
            'nm_posisi' => $request->posisi,
        ];

        Posisi::create($data);

        return redirect()->route('posisi')->with('sukses', 'Berhasil tambah posisi');
    }

    public function editPosisi(Request $request)
    {
        $data = [
            'nm_posisi' => $request->posisi,
        ];
    
        Posisi::where('id_posisi',$request->id_posisi)->update($data);

      
        return redirect()->route('posisi')->with('sukses', 'Berhasil Ubah Data Posisi');
    }

    public function deletePosisi(Request $request)
    {
        Posisi::where('id_posisi',$request->id_posisi)->delete();
        return redirect()->route('posisi')->with('error', 'Berhasil hapus posisi');
    }
}
