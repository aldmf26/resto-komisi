<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
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
                    'title' => 'Status',
                    'logout' => $request->session()->get('logout'),
                    'status' => Status::orderBy('id_status', 'desc')->get(),
                ];
                return view("status.status",$data);
            } else {
                return back();
            }
            
        }
    }

    public function addStatus(Request $request)
    {   
        $data = [
            'nm_status' => $request->status,
        ];

        Status::create($data);

        return redirect()->route('status')->with('sukses', 'Berhasil tambah status');
    }

    public function editStatus(Request $request)
    {
        $data = [
            'nm_status' => $request->status,
        ];
    
        Status::where('id_status',$request->id_status)->update($data);

      
        return redirect()->route('status')->with('sukses', 'Berhasil Ubah Data Status');
    }

    public function deleteStatus(Request $request)
    {
        Status::where('id_status',$request->id_status)->delete();
        return redirect()->route('status')->with('error', 'Berhasil hapus status');
    }
}
