<?php

namespace App\Http\Controllers;

use App\Models\Tips;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TipsController extends Controller
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
                'title' => 'Data Tips',
                'logout' => $request->session()->get('logout'),
                'tips' => Tips::orderBy('id_tips','desc')->get()
            ];
    
            return view('tips.tips', $data);
        }
    }

    public function addTips(Request $request)
    {
        $data = [
            'tgl' => date('Y-m-d'),
            'nominal' => $request->nominal,
            'admin' => Auth::user()->nama,
        ];
        Tips::create($data);
        return redirect()->route('tips')->with('sukses', 'Berhasil tambah tips');
    }

    public function editTips(Request $request)
    {
        $data = [
            'nominal' => $request->nominal,
        ];
        Tips::where('id_tips',$request->id_tips)->update($data);
        return redirect()->route('tips')->with('sukses', 'Berhasil ubah tips');
    }

    public function deleteTips(Request $request)
    {
        Tips::where('id_tips', $request->id_tips)->delete();
        return redirect()->route('tips')->with('error', 'Berhasil hapus tips');
    }
}
