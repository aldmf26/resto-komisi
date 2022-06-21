<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DistribusiController extends Controller
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
        ->where('id_menu', 14)->first();
        if(empty($id_menu)) {
            return back();
        } else {
            if(Auth::user()->jenis == 'adm') {
                $data = [
                    'title' => 'Distribusi',
                    'logout' => $request->session()->get('logout'),
                    'distribusi' => Distribusi::all()
                ];
                return view("distribusi.distribusi",$data);
            } else {
                return back();
            }
            
        }
    }

    public function addDistribusi(Request $request)
    {
        $data = [
            'nm_distribusi' => $request->nm_distribusi,
            'service' => 'T',
            'ongkir' => 'T',
            'tax' => 'T',
        ];

        Distribusi::create($data);
        return redirect()->route('distribusi')->with('sukses', 'Berhasil tambah distribusi');
        
    }

    public function updateDistribusi(Request $request )
    {
        if($request->status == 'service')
        {
            $data = ['service' => $request->v,];
        }
        if($request->status == 'ongkir')
        {
            $data = ['ongkir' => $request->v,];
        }
        if($request->status == 'tax')
        {
            $data = ['tax' => $request->v,];
        }
        Distribusi::where('id_distribusi',$request->id_distribusi)->update($data);
        return true;
        
    }

    public function inputDistribusi(Request $request )
    {
        if($request->status == 'service')
        {
            $data = ['service' => $request->v,];
        }
        if($request->status == 'ongkir')
        {
            $data = ['ongkir' => $request->v,];
        }
        if($request->status == 'tax')
        {
            $data = ['tax' => $request->v,];
        }
        Distribusi::where('id_distribusi',$request->id_distribusi)->update($data);
        return true;
        
    }
}
