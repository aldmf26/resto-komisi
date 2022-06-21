<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 30)->first();
        if (empty($id_menu)) {
            return back();
        } else {
            $tl1 = $request->tgl1;
            $tl2 = $request->tgl2;
            $loc = $request->session()->get('id_lokasi');
            if (empty($tl1)) {
                $tgl1 = date('Y-m-d');
                $tgl2 = date('Y-m-d');
            } else {
                $tgl1 = $tl1;
                $tgl2 = $tl2;
            }

            $data = [
                'title'    => 'Invoice',
                'logout' => $request->session()->get('logout'),
                'invoice' => DB::select("SELECT a.*, d.nm_meja
                FROM tb_transaksi AS a
                LEFT JOIN tb_order2 AS b ON b.no_order2 = a.no_order
                LEFT JOIN tb_order AS c ON c.no_order = b.no_order
                LEFT JOIN tb_meja AS d ON d.id_meja = c.id_meja
                WHERE a.tgl_transaksi between '$tgl1' and '$tgl2' and a.id_lokasi = '$loc'
                GROUP BY a.no_order
                ")
            ];

            return view('invoice.invoice', $data);
        }
    }

    public function invoice1(Request $request)
    {
        $loc = $request->session()->get('id_lokasi');
        $tl = $request->tgl;
        $tl2 = $request->tgl2;
        if (empty($tl)) {
            $tgl = date('Y-m-d');
            $tgl2 = date('Y-m-d');
        } else {
            $tgl = $tl;
            $tgl2 = $tl2;
        }
        if ($loc == 1) {
            $lokasi = 'TAKEMORI';
        } else {
            $lokasi = 'SOONDOBU';
        }

        $data = [
            'title' => 'Data Orderan',
            'logout' => $request->session()->get('logout'),
            'invoice' => DB::table('tb_transaksi')->join('tb_order', 'tb_transaksi.no_order', '=', 'tb_order.no_order')->join('tb_meja', 'tb_order.id_meja', '=', 'tb_meja.id_meja')->groupBy('tb_transaksi.no_order')->whereBetween('tb_transaksi.tgl_transaksi', [$tgl, $tgl2])->get(),
        ];
        return view('invoice.invoice1', $data);
    }
}
