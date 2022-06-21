<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kasbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class KasbonController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 2)->first();
        if(empty($id_menu)) {
            return back();
        } else {

            $data = [
                'title' => 'Data Kasbon',
                'logout' => $request->session()->get('logout'),
                'kasbon' => Kasbon::orderBy('id_kasbon','desc')->get(),
                'karyawan' => Karyawan::all()
            ];
    
            return view('kasbon.kasbon', $data);
        }
    }

    public function addKasbon(Request $request)
    {   
        $nm_karyawan = $request->nama;
        $nominal = $request->nominal;
        $tgl = $request->tgl;
        for ($i=0; $i < count($nm_karyawan) ; $i++) { 
            $data = [
                'nm_karyawan' => $nm_karyawan[$i],
                'nominal' => $nominal[$i],
                'tgl' => $tgl,
                'admin' => Auth::user()->nama,
            ];
            Kasbon::create($data);
        }
        

       

        return redirect()->route('kasbon')->with('sukses', 'Berhasil tambah kasbon');
    }

    public function editKasbon(Request $request)
    {
        $data = [
            'nm_karyawan' => $request->nama,
            'nominal' => $request->nominal,
            'tgl' => $request->tgl,
            'admin' => Auth::user()->nama
        ];
    
        kasbon::where('id_kasbon',$request->id_kasbon)->update($data);

      
        return redirect()->route('kasbon')->with('sukses', 'Berhasil Ubah Data kasbon');
    }

    public function deleteKasbon(Request $request)
    {
        kasbon::where('id_kasbon',$request->id_kasbon)->delete();
        return redirect()->route('kasbon')->with('error', 'Berhasil hapus kasbon');
    }

    public function printKasbon(Request $request)
    {
        $tglDari = $request->dari;
        $tglSampai = $request->sampai;
        if (empty($tglDari)) {
            $dari = date('Y-m-1');
            $sampai = date('Y-m-d');
        } else {
            $dari = $tglDari;
            $sampai = $tglSampai;
        }
        // dd($sampai);
        $data = [
            'title' => 'Kasbon Prtint',
            'date' => date('m/d/Y'),
            'dari' => $dari,
            'sampai' => $sampai,
            'kasbon' => DB::select("SELECT *, SUM(nominal) as totalNominal from tb_kasbon WHERE tgl BETWEEN '$dari' AND '$sampai' GROUP BY nm_karyawan"),
            'sum' => Kasbon::whereBetween('tgl', [$dari,$sampai])->sum('nominal'),
        ];
        
        return view('kasbon.pdf', $data);
        // $pdf = PDF::loadView('kasbon.pdf', $data);

        // return $pdf->download('Data Kasbon.pdf');
    }
}
