<?php

namespace App\Http\Controllers;

use App\Models\Limit;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LimitController extends Controller
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
        ->where('id_menu', 20)->first();
        if(empty($id_menu)) {
            return back();
        } else {
            if (empty($request->id_dis2)) {
                $id_me = '1';
            } else {
                $id_me = $request->id_dis2;
            }
            if (empty($request->id_dis)) {
                $id = '1';
            } elseif ($request->id_dis != '2') {
                $id = '1';
            } else {
                $id = '2';
            }
            $lokasi = $request->session()->get('id_lokasi');
            
            $tgl = date('Y-m-d');
            $data = [
                'title' => 'Limit',
                'logout' => $request->session()->get('logout'),
                'menu' => DB::select("SELECT tb_menu.id_menu, tb_menu.nm_menu FROM tb_menu  WHERE lokasi = $lokasi AND aktif = 'on' AND id_menu NOT IN (SELECT tb_limit.id_menu FROM tb_limit WHERE tb_limit.tgl = '$tgl') AND id_menu NOT IN (SELECT tb_sold_out.id_menu FROM tb_sold_out WHERE tb_sold_out.tgl = '$tgl')"),
                'limit' => DB::table('tb_limit')->join('tb_menu', 'tb_limit.id_menu', 'tb_menu.id_menu')->where('id_lokasi', $lokasi)->orderBy('id_limit', 'desc')->get()
            ];
    
            return view('limit.limit', $data);
        }
    }

    public function add_limit(Request $request)
    {
        $loc = $request->session()->get('id_lokasi');
        $tgl = date('Y-m-d');
        $id_menu = $request->id_menu;
        $batas_limit = $request->batas_limit;
        $admin = Auth::user()->nama;
        
        $dt_limit = DB::selectOne("SELECT dt_order.jml_jual as jml_jual  FROM tb_menu 
        LEFT JOIN(SELECT SUM(qty) as jml_jual, tb_harga.id_menu FROM tb_order LEFT JOIN tb_harga ON tb_order.id_harga = tb_harga.id_harga WHERE tb_order.id_lokasi = $loc AND tb_order.tgl = '$tgl' AND tb_order.void = 0 GROUP BY tb_harga.id_menu) dt_order ON tb_menu.id_menu = dt_order.id_menu
        
        WHERE lokasi = $loc AND tb_menu.id_menu = $id_menu");

            $data = [
                'id_menu' => $id_menu,
                'id_lokasi' => $loc,
                'tgl' => $tgl,
                'admin' => $admin,
                'jml_limit' => $batas_limit,
                'batas_limit' => $batas_limit + $dt_limit->jml_jual
            ];

            Limit::create($data);
        
            return redirect()->route('limit')->with('success', 'Data Berhasil diinput');

    }

    public function hapus_limit(Request $request)
    {
        Limit::where('id_limit', $request->id_limit)->delete();
        return redirect()->route('limit')->with('error', 'Data Berhasil dihapus');
    }
    
}
