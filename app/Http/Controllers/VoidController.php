<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoidController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 31)->first();
        if (empty($id_menu)) {
            return back();
        } else {
            $loc = $request->session()->get('id_lokasi');

            $data = [
                'title' => 'Data Orderan',
                'logout' => $request->session()->get('logout'),
                'tb_order' => DB::select("SELECT a.* ,b.nm_menu, c.nm_meja, d.nama AS koki1 , e.nama AS koki2, f.nama AS koki3,
            timestampdiff(MINUTE, a.j_mulai,a.wait) AS selisih
            FROM tb_order as a 
            left join view_menu as b on a.id_harga = b.id_harga
            LEFT JOIN tb_meja AS c ON c.id_meja = a.id_meja
            LEFT JOIN tb_karyawan AS d ON d.id_karyawan = a.id_koki1
            LEFT JOIN tb_karyawan AS e ON e.id_karyawan = a.id_koki2
            LEFT JOIN tb_karyawan AS f ON f.id_karyawan = a.id_koki3
            WHERE a.id_lokasi = '$loc' AND a.void = 1"),
                'nav' => '5'
            ];

            return view('void.void', $data);
        }
    }
}
