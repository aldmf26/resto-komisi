<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Karyawan;
use App\Models\Koki;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TabelController extends Controller
{
    public function index(Request $request)
    {
        $id_departemen = $request->id_departemen;
        // select('absensi_resto.*','karyawan.*')
        // ->join('karyawan','absensi_resto.id_karyawan', '=', 'karyawan.id_karyawan')->orderBy('id', 'desc'),
        if (empty($request->bulan)) {
            $bulan = date('m');
         } else {
             $bulan = $request->bulan;
         }
         if (empty($request->tahun)) {
            $tahun = date('Y');
         } else {
             $tahun = $request->tahun;
         }

        $data = [
            'title' => 'Absensi',
            'logout' => $request->session()->get('logout'),
            'absensi' => Absen::select('tb_absen.*', 'tb_karyawan.nama')->join('tb_karyawan', 'tb_absen.id_karyawan', '=', 'tb_karyawan.id_karyawan')->orderBy('id_absen', 'desc')->get(),
            'karyawan' => Karyawan::all(),
            'tahun' => Absen::all(),
            'status' => DB::table('status')->get(),
            'bulan' => $bulan,
            'tahun_2' => $tahun,
            's_tahun' => DB::select(DB::raw("SELECT YEAR(a.tgl) as tahun FROM tb_absen as a group by YEAR(a.tgl)")),
            'aktif' => 2,
            'id_departemen' => $id_departemen,
        ];


        return view('absen.tabelAbsens', $data);
    }

    public function tabelKoki(Request $request)
    {
        $data = [
            'koki' => Koki::join('tb_karyawan', 'tb_koki.id_karyawan', '=','tb_karyawan.id_karyawan')->where('tb_koki.id_lokasi', $request->session()->get('id_lokasi'))->where('tgl', date('Y-m-d'))->get(),
        ];

        return view('addKoki.tabelKoki', $data);
    }
}
