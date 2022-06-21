<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OngkirController extends Controller
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
        ->where('id_menu', 15)->first();
        if(empty($id_menu)) {
            return back();
        } else {
            if(Auth::user()->jenis == 'adm') {
                $data = [
                    'title' => 'ongkir',
                    'logout' => $request->session()->get('logout'),
                    'ongkir' => DB::table('tb_ongkir')->get(),
                    'batas_ongkir' => DB::table('tb_batas_ongkir')->get(),
                ];
                return view("ongkir.ongkir",$data);
            } else {
                return back();
            }
            
        }
    }

    public function editOngkir(Request $request)
    {
        $data = [
            'rupiah' => $request->rupiah,
        ];
        DB::table('tb_ongkir')->where('id_ongkir', $request->id_ongkir)->update($data);
        return redirect()->route('ongkir');
    }

    public function editBatasOngkir(Request $request)
    {
        $data = [
            'rupiah' => $request->rupiah,
        ];
        DB::table('tb_batas_ongkir')->where('id_batas_ongkir', $request->id_batas_ongkir)->update($data);
        return redirect()->route('ongkir');
    }

    
    
}
