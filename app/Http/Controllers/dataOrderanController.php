<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\Invoice;
use App\Models\Karyawan;
use App\Models\Koki;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class dataOrderanController extends Controller
{
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Makassar');
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 29)->first();
        if (empty($id_menu)) {
            return back();
        } else {
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
                'tb_order' => DB::select("SELECT a.* ,b.nm_menu, c.nm_meja, d.nama AS koki1 , e.nama AS koki2, f.nama AS koki3,
            timestampdiff(MINUTE, a.j_mulai,a.wait) AS selisih, tb_order2.id_order1 as cek_bayar
            FROM tb_order as a 
            left join view_menu as b on a.id_harga = b.id_harga
            LEFT JOIN tb_meja AS c ON c.id_meja = a.id_meja
            LEFT JOIN tb_karyawan AS d ON d.id_karyawan = a.id_koki1
            LEFT JOIN tb_karyawan AS e ON e.id_karyawan = a.id_koki2
            LEFT JOIN tb_karyawan AS f ON f.id_karyawan = a.id_koki3
            LEFT JOIN tb_order2 ON a.id_order = tb_order2.id_order1
            WHERE a.tgl between '$tgl' and '$tgl2' and a.id_lokasi = '$loc'  and a.void = 0 order by a.id_order DESC"),

                'kategori' => DB::table('tb_kategori')->where('lokasi', $lokasi)->get(),
                'distribusi' => Distribusi::all(),
                'tb_koki' => Koki::join('tb_karyawan', 'tb_karyawan.id_karyawan', '=', 'tb_koki.id_karyawan')->where('tb_koki.tgl', $tgl)->get(),
                'nav' => '5'
            ];

            return view('dataOrderan.dataOrderan', $data);
        }
    }

    public function order1(Request $request)
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
            'tb_order' => DB::select("SELECT a.* ,b.nm_menu, c.nm_meja, d.nama AS koki1 , e.nama AS koki2, f.nama AS koki3,
            timestampdiff(MINUTE, a.j_mulai,a.wait) AS selisih, tb_order2.id_order1 as cek_bayar
            FROM tb_order as a 
            left join view_menu as b on a.id_harga = b.id_harga
            LEFT JOIN tb_meja AS c ON c.id_meja = a.id_meja
            LEFT JOIN tb_karyawan AS d ON d.id_karyawan = a.id_koki1
            LEFT JOIN tb_karyawan AS e ON e.id_karyawan = a.id_koki2
            LEFT JOIN tb_karyawan AS f ON f.id_karyawan = a.id_koki3
            LEFT JOIN tb_order2 ON a.id_order = tb_order2.id_order1
            WHERE a.tgl between '$tgl' and '$tgl2' and a.id_lokasi = '$loc'  and a.void = 0 order by a.id_order DESC"),

            'kategori' => DB::table('tb_kategori')->where('lokasi', $lokasi)->get(),
            'distribusi' => Distribusi::all(),
            'tb_koki' => Koki::join('tb_karyawan', 'tb_karyawan.id_karyawan', '=', 'tb_koki.id_karyawan')->where('tb_koki.tgl', $tgl)->get(),
            'nav' => '5'
        ];
        return view('dataOrderan.order1', $data);
    }

    public function orderan_void(Request $request)
    {
        $id_order = $request->id_order;
        $data = [
            'alasan' => $request->alasan,
            'void' => 1,
            'nm_void' => Auth::user()->nama,
        ];
        Order::where('id_order', $id_order)->update($data);

        return redirect()->route('order1');
    }

    public function drop(Request $request)
    {
        $dt_order = Order::where('id_order', $request->id)->first();
        

        $jml = DB::selectOne("SELECT COUNT(id_order) as sisa_order FROM tb_order WHERE no_order = '$dt_order->no_order' GROUP BY no_order");


        if($jml->sisa_order > 1){
            Order::where('id_order', $request->id)->delete();
        }else{
            Order::where('id_order', $request->id)->delete();
            Invoice::where('no_invoice', $dt_order->no_order)->delete();
        }
        // $jml->sisa_order;

        return redirect()->route('dataOrderan')->with('error', 'Data berhasil dihapus');
    }

    public function edit_order(Request $request)
    {
        $id_order = $request->id_order;
        $data = [
            'qty' => $request->qty,
            'request' => $request->keterangan,
        ];
        Order::where('id_order', $id_order)->update($data);

        return redirect()->route('dataOrderan')->with('error', 'Data berhasil diedit');
    }
    
    public function edit_orderAdmin(Request $request)
    {
        Order::where('id_order',$request->id_order)->update(['admin' => $request->admin]);
        return redirect()->route('order1', ['tgl' => $request->dari, 'tgl2' => $request->sampai])->with('error', 'Data berhasil diedit');
    }
}
