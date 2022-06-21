<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\SoldOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SoldOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $lokasi = $request->session()->get('id_lokasi');
        $tgl = date('Y-m-d');
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 18)->first();
        if(empty($id_menu)) {
            return back();
        } else {

            $data = [
                'title' => 'Sold Out',
                'logout' => $request->session()->get('logout'),
                'menu' => DB::select("SELECT tb_menu.id_menu, tb_menu.nm_menu FROM tb_menu  WHERE lokasi = $lokasi AND aktif = 'on' AND id_menu NOT IN (SELECT tb_sold_out.id_menu FROM tb_sold_out WHERE tb_sold_out.tgl = '$tgl')"),

                'sold_out' => SoldOut::select('tb_sold_out.*','tb_menu.nm_menu')->join('tb_menu', 'tb_sold_out.id_menu','=','tb_menu.id_menu')->where('tb_sold_out.tgl', $tgl)->where('tb_sold_out.id_lokasi', $lokasi)->orderBy('tb_sold_out.id_sold_out','desc')->get()
            ];
    
            return view('soldOut.soldOut', $data);
        }
    }

    public function addSoldOut(Request $request)
    {
        
        for($i = 0; $i < count($request->id_menu); $i++)
        {
            $data = [
                'tgl' => date('Y-m-d'),
                'id_status' => $request->status,
                'id_menu' => $request->id_menu[$i],
                'id_lokasi' => $request->session()->get('id_lokasi'),
                'admin' => Auth::user()->nama,
            ];
    
           SoldOut::create($data);
        }


        return redirect()->route('soldOut')->with('sukses', 'Berhasil tambah soldout');
    }

    public function hapusSoldOut(Request $request)
    {

        SoldOut::where('id_sold_out', $request->id)->delete();
        return redirect()->route('soldOut')->with('error', 'Berhasil hapus soldout');
    }
}
