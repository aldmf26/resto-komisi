<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 4)->first();
        if(empty($id_menu)) {
            return back();
        } else {
            $data = [
                'title' => 'Data Driver',
                'logout' => $request->session()->get('logout'),
                'driver' => Driver::all(),
            ];
    
            return view('driver.driver', $data);
        }
    }

    public function printDriver(Request $request)
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
            'driver' => DB::select("SELECT *, SUM(nominal) as totalNominal from ctt_driver WHERE tgl BETWEEN '$dari' AND '$sampai' GROUP BY nm_driver"),
            'sum' => Driver::whereBetween('tgl', [$dari,$sampai])->sum('nominal'),
        ];
        
        return view('driver.print', $data);
        // $pdf = PDF::loadView('kasbon.pdf', $data);

        // return $pdf->download('Data Kasbon.pdf');
    }
}
