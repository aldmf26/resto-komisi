<?php

namespace App\Http\Controllers;

use App\Models\Point_kerja as ModelsPoint_kerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Point_kerja extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menus = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 11)->first();
        if (empty($id_menus)) {
            return back()->with('warning', 'Permission belum diatur');
        } else {
            if (Auth::user()->jenis == 'adm') {
                $id_lokasi = $request->id_lokasi;
                $data = [
                    'title' => 'Menu',
                    'logout' => $request->session()->get('logout'),
                    'tb_kerja' => ModelsPoint_kerja::all(),
                    'id_lokasi' => $id_lokasi
                ];

                return view("point_kerja.index", $data);
            } else {
                return back();
            }
        }
    }
    
    public function excel_point(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menus = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 11)->first();
        if (empty($id_menus)) {
            return back()->with('warning', 'Permission belum diatur');
        } else {
            if (Auth::user()->jenis == 'adm') {
                $id_lokasi = $request->id_lokasi;
                $data = [
                    'title' => 'Menu',
                    'logout' => $request->session()->get('logout'),
                    'tb_kerja' => ModelsPoint_kerja::all(),
                    'id_lokasi' => $id_lokasi
                ];

                return view("point_kerja.excel", $data);
            } else {
                return back();
            }
        }
    }

    public function tambah_ket(Request $request)
    {
        $data = [
            'ket' => $request->ket,
            'point' => $request->point
        ];
        ModelsPoint_kerja::create($data);
        return redirect()->route('point_kerja')->with('sukses', 'Data berhasil ditambahkan');
    }
    public function update_ket(Request $request)
    {
        $data = [
            'ket' => $request->ket,
            'point' => $request->point
        ];
        ModelsPoint_kerja::where('id_ket', $request->id_ket)->update($data);
        return redirect()->route('point_kerja')->with('sukses', 'Data berhasil ditambahkan');
    }
    
    public function hapus_ket(Request $request)
    {
        ModelsPoint_kerja::where('id_ket', $request->id_ket)->delete();
        return redirect()->route('point_kerja')->with('sukses', 'Data berhasil dihapus');
    }
}
