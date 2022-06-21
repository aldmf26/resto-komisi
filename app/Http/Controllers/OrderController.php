<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\Order;
use App\Models\Orderan;
use App\Models\Invoice;
use App\Models\Limit;
use App\Models\SoldOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 25)->first();
        if (empty($id_menu)) {

            return back();
        } else {
            $id_dis = $request->dis;

            if (empty($id_dis)) {
                $id_me = '1';
            } else {
                $id_me = $id_dis;
            }
            if (empty($id_dis)) {
                $id = '1';
            } elseif ($id_dis != '2') {
                $id = '1';
            } else {
                $id = '2';
            }
            $id_lokasi = $request->session()->get('id_lokasi');
            $date = date('Y-m-d');
            if( $id_lokasi == '1'){
                $lokasi = 'TAKEMORI';
            }else{
                $lokasi = 'SOONDOBU';
            }
            
            $meja = DB::select(
                DB::raw("SELECT *
                FROM tb_meja AS a
                WHERE a.id_meja NOT IN (SELECT b.id_meja from tb_order AS b WHERE b.tgl = '$date' or b.aktif = '1' ) and a.id_lokasi = '$id_lokasi' and a.id_distribusi = '$id_me'"),
            );
            $data = [
                'title' => 'Order',
                'logout' => $request->session()->get('logout'),
                'distribusi' => Distribusi::all(),
                'id' => $id,
                'id_dis' => $id_me,
                'meja' => $meja,
                'tb_menu' => DB::select("SELECT a.id_harga, a.id_distribusi, a.id_menu, b.nm_menu, c.nm_distribusi, a.harga,b.image
                FROM tb_harga AS a 
                LEFT JOIN tb_menu AS b ON b.id_menu = a.id_menu 
                LEFT JOIN tb_distribusi AS c ON c.id_distribusi = a.id_distribusi
                where a.id_distribusi = '$id' AND b.lokasi ='$id_lokasi' and b.aktif = 'on' AND b.id_menu NOT IN (SELECT tb_sold_out.id_menu FROM tb_sold_out WHERE tb_sold_out.tgl = '$date')
                GROUP BY a.id_harga"),
                'kategori' => DB::table('tb_kategori')
                    ->select(DB::raw('*, SUBSTRING(kategori, 1, 3) AS ket'))
                    ->where('lokasi', $lokasi)
                    ->orderBy('kategori', 'ASC')->groupBy('kategori')
                    ->get(),
                'cart' => Cart::content(),
                'id_distri' => DB::table('tb_distribusi')
                    ->where('id_distribusi', $id_me)
                    ->first(),
            ];
            Cart::destroy();
            return view('order.index', $data);
        }
    }

    public function get(Request $request)
    {
        if (empty($request->id_dis2)) {
            $id_me = '1';
        } else {
            $id_me = $request->id_dis2;
        }
        if (empty($request->id_dis)) {
            $id = '1';
        } elseif ($request->id_dis != '2') {
            $id = '1';
        } else {
            $id = '2';
        }
        $tgl = date('Y-m-d');
        $id_lokasi = $request->session()->get('id_lokasi');



        // if($ids) {
        //     $notin = "->whereNotIn('view_menu.id_menu', $ids)";
        // } else {
        //     $notin = "";
        // }


        $ids = [];
        $sold_out = SoldOut::where('tgl', $tgl)->get();
        foreach ($sold_out as $s) {
            $ids[] = $s->id_menu;
        }

        $idl = [];
        $limit = DB::select("SELECT tb_menu.id_menu as id_menu FROM tb_menu 
        LEFT JOIN(SELECT SUM(qty) as jml_jual, tb_harga.id_menu FROM tb_order LEFT JOIN tb_harga ON tb_order.id_harga = tb_harga.id_harga WHERE tb_order.id_lokasi = $id_lokasi AND tb_order.tgl = '$tgl' AND tb_order.void = 0 GROUP BY tb_harga.id_menu) dt_order ON tb_menu.id_menu = dt_order.id_menu
        LEFT JOIN(SELECT id_menu,batas_limit FROM tb_limit WHERE tgl = '$tgl' AND id_lokasi = $id_lokasi GROUP BY id_menu)dt_limit ON tb_menu.id_menu = dt_limit.id_menu
        WHERE lokasi = $id_lokasi AND dt_order.jml_jual >= dt_limit.batas_limit");
        foreach ($limit as $l) {
            $idl[] = $l->id_menu;
        }

        $vm = DB::table('view_menu')
            ->where('lokasi', $id_lokasi)
            ->where('id_distribusi', $id)
            ->where('akv', 'on')
            ->whereNotIn('view_menu.id_menu', $ids)
            ->whereNotIn('view_menu.id_menu', $idl)
            ->paginate(12);

        $data = [
            'menu2' => $vm,

            'menu21' => DB::select("SELECT a.id_harga, a.id_distribusi, a.id_menu, b.nm_menu, c.nm_distribusi, a.harga,b.image
                FROM tb_harga AS a 
                LEFT JOIN tb_menu AS b ON b.id_menu = a.id_menu 
                LEFT JOIN tb_distribusi AS c ON c.id_distribusi = a.id_distribusi
                where a.id_distribusi = '$id' AND b.lokasi ='$id_lokasi' and b.aktif = 'on' AND b.id_menu NOT IN (SELECT tb_sold_out.id_menu FROM tb_sold_out WHERE tb_sold_out.tgl = '$tgl')
                GROUP BY a.id_harga"),

            'id_dis' => $id_me,
            'title' => 'Order',
        ];

        return view('order.get', ['page' => 1], $data)->render();
    }



    public function get_meja(Request $request)
    {
        $id_dis = $request->dis;

        if (empty($id_dis)) {
            $id_me = '1';
        } else {
            $id_me = $id_dis;
        }
        if (empty($id_dis)) {
            $id = '1';
        } elseif ($id_dis != '2') {
            $id = '1';
        } else {
            $id = '2';
        }
        $id_lokasi = $request->session()->get('id_lokasi');
        $date = date('Y-m-d');

        $meja = DB::select(
            DB::raw("SELECT *
        FROM tb_meja AS a
        WHERE a.id_meja NOT IN (SELECT b.id_meja from tb_order AS b WHERE b.tgl = '$date' or b.aktif = '1' ) and a.id_lokasi = '$id_lokasi' and a.id_distribusi = '$id_me'"),
        );

        foreach ($meja as $m) {
            echo '<option value="' . $m->id_meja . '">' . $m->nm_meja . '</option>';
        }
    }

    public function cari(Request $request)
    {
        if (empty($request->dis2)) {
            $id_me = '1';
        } else {
            $id_me = $request->dis2;
        }
        if (empty($request->dis)) {
            $id = '1';
        } elseif ($request->dis != '2') {
            $id = '1';
        } else {
            $id = '2';
        }
        $tgl = date('Y-m-d');
        $id_lokasi = $request->session()->get('id_lokasi');
        // soldout
        $ids = [];
        $sold_out = SoldOut::where('tgl', $tgl)->get();
        foreach ($sold_out as $s) {
            $ids[] = $s->id_menu;
        }

        // limit
        $idl = [];
        $limit = DB::select("SELECT tb_menu.id_menu as id_menu FROM tb_menu 
        LEFT JOIN(SELECT SUM(qty) as jml_jual, tb_harga.id_menu FROM tb_order LEFT JOIN tb_harga ON tb_order.id_harga = tb_harga.id_harga WHERE tb_order.id_lokasi = $id_lokasi AND tb_order.tgl = '$tgl' AND tb_order.void = 0 GROUP BY tb_harga.id_menu) dt_order ON tb_menu.id_menu = dt_order.id_menu
        LEFT JOIN(SELECT id_menu,batas_limit FROM tb_limit WHERE tgl = '$tgl' AND id_lokasi = $id_lokasi GROUP BY id_menu)dt_limit ON tb_menu.id_menu = dt_limit.id_menu
        WHERE lokasi = $id_lokasi AND dt_order.jml_jual >= dt_limit.batas_limit");
        foreach ($limit as $l) {
            $idl[] = $l->id_menu;
        }

        $vm = DB::table('view_menu')
            ->where('lokasi', $id_lokasi)
            ->where('id_distribusi', $id)
            ->where('nm_menu', 'LIKE', '%' . $request->keyword . '%')
            ->where('akv', 'on')
            ->whereNotIn('view_menu.id_menu', $ids)
            ->whereNotIn('view_menu.id_menu', $idl)
            ->get();

        $data = [
            'menu2' => $vm,
            'id_dis' => $id_me,
            'title' => 'Order',
        ];

        return view('order.search', $data)->render();
    }

    public function get_harga(Request $request)
    {
        $id_harga = $request->id_harga;
        $id_dis = $request->id_dis;
        $menu = DB::table('view_menu')
            ->where('id_harga', $id_harga)
            ->first();
        $data = [
            'menu' => $menu,
            'id_dis' => $id_dis,
        ];
        return view('order.item', $data)->render();
    }

    public function cart(Request $request)
    {
        $id_lokasi = $request->session()->get('id_lokasi');
        $date = date('Y-m-d');
        $id = $request->id_harga2;
        $price = $request->price;
        $nama = $request->name;
        $qty = $request->qty;
        $req = $request->req;
        $id_menu = $request->id_menu;

        
        


        $detail = DB::selectOne("SELECT a.id_harga, a.id_menu, b.nm_menu, c.nm_distribusi, a.harga,b.image
        FROM tb_harga AS a 
        LEFT JOIN tb_menu AS b ON b.id_menu = a.id_menu 
        LEFT JOIN tb_distribusi AS c ON c.id_distribusi = a.id_distribusi
        where a.id_harga = '$id'
        GROUP BY a.id_harga");


        $dt_limit = DB::selectOne("SELECT dt_order.jml_jual as jml_jual, dt_limit.batas_limit as batas_limit  FROM tb_menu 
        LEFT JOIN(SELECT SUM(qty) as jml_jual, tb_harga.id_menu FROM tb_order LEFT JOIN tb_harga ON tb_order.id_harga = tb_harga.id_harga WHERE tb_order.id_lokasi = $id_lokasi AND tb_order.tgl = '$date' AND tb_order.void = 0 GROUP BY tb_harga.id_menu) dt_order ON tb_menu.id_menu = dt_order.id_menu
        LEFT JOIN(SELECT id_menu,batas_limit FROM tb_limit WHERE tgl = '$date' AND id_lokasi = $id_lokasi GROUP BY id_menu)dt_limit ON tb_menu.id_menu = dt_limit.id_menu
        WHERE lokasi = $id_lokasi AND tb_menu.id_menu = $detail->id_menu");
        if ($dt_limit->batas_limit > 0 && $dt_limit->jml_jual + $qty > $dt_limit->batas_limit) {
            echo $dt_limit->batas_limit - $dt_limit->jml_jual;
        } else {
            Cart::add(['id' => $id, 'name' => $nama, 'price' => $price, 'qty' => $qty, 'options' => ['req' => $req, 'id_menu' => $id_menu]]);
            echo 'berhasil';
        }
    }

    public function destroy_card()
    {
        Cart::destroy();
    }

    public function keranjang(Request $request)
    {
        $id_dis = $request->dis;

        if (empty($id_dis)) {
            $id_me = '1';
        } else {
            $id_me = $id_dis;
        }
        $ongkir = DB::table('tb_ongkir')
            ->select(DB::raw('*, SUM(rupiah) AS rupiah'))
            ->first();

        $data = [
            'cart' => Cart::content(),
            'id_menu' => $request->id_menu,
            'id_distri' => DB::table('tb_distribusi')
                ->where('id_distribusi', $id_me)
                ->first(),
            'batas' => DB::table('tb_batas_ongkir')->first(),
            'onk' => $ongkir,
        ];

        return view('order.keranjang', $data)->render();
    }
    public function delete_order(Request $request)
    {
        $rowId = $request->rowid;
        Cart::remove($rowId);
    }
    public function min_cart(Request $request)
    {
        $rowId = $request->rowid;
        $qty = $request->qty - 1;
        Cart::update($rowId, ['qty' => $qty]);
    }

    public function plus_cart(Request $request)
    {
        $rowId = $request->rowid;
        $qty = $request->qty + 1;
        Cart::update($rowId, ['qty' => $qty]);
    }
    public function payment(Request $request)
    {
        $meja = $request->meja;
        $orang = $request->orang;
        $id_distribusi = $request->distribusi;
        $now = date('Y-m-d');

        if (empty($id_distribusi)) {
            $id_me = '1';
        } else {
            $id_me = $id_distribusi;
        }
        $ongkir = DB::table('tb_ongkir')
            ->select(DB::raw('*, SUM(rupiah) AS rupiah'))
            ->first();

        $data = [
            'cart' => Cart::content(),
            'id_distri' => DB::table('tb_distribusi')
                ->where('id_distribusi', $id_me)
                ->first(),
            'batas' => DB::table('tb_batas_ongkir')->first(),
            'onk' => $ongkir,
            'page' => DB::table('tb_meja')
                ->where('id_meja', $meja)
                ->first(),
            'dis' => DB::table('tb_distribusi')
                ->where('id_distribusi', $id_distribusi)
                ->first(),
            'orang' => $orang,
            'distribusi' => $id_distribusi,
        ];

        return view('order.payment', $data)->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id_dis = $request->id_distribusi;
        $loc = $request->session()->get('id_lokasi');
        $q = DB::select(
            DB::raw("SELECT MAX(RIGHT(a.no_order,4)) AS kd_max FROM tb_order AS a
        WHERE DATE(a.tgl)=CURDATE() AND a.id_lokasi = '$loc' AND a.id_distribusi = '$id_dis'"),
        );
        $kd = '';
        if (count($q) > 0) {
            foreach ($q as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf('%04s', $tmp);
            }
        } else {
            $kd = '0001';
        }
        date_default_timezone_set('Asia/Makassar');
        $no_invoice = date('ymd') . $kd;

        $dis = DB::table('tb_distribusi')
            ->where('id_distribusi', $id_dis)
            ->first();
        $kode = strtoupper(substr($dis->nm_distribusi, 0, 2));
        $loc = $loc;
        if ($loc == '1') {
            $hasil = "T$kode-$no_invoice";
        } else {
            $hasil = "S$kode-$no_invoice";
        }
        $data = [
            'no_invoice' => $hasil,
            'tanggal' => date('Y-m-d'),
        ];
        Invoice::create($data);

        // dd($request->req);
        $meja = $request->id_meja;
        $id_harga = $request->id_harga;
        $qty = $request->qty;
        $price = $request->harga;
        $ongkir = $request->ongkir;
        $orang = $request->orang;
        $lokasi = $request->session()->get('id_lokasi');
        $pesan = $request->req;
        
        $date = date('Y-m-d');
        $last_meja = DB::selectOne("SELECT *
        FROM tb_meja AS a
        WHERE a.id_meja NOT IN (SELECT b.id_meja from tb_order AS b WHERE b.tgl = '$date' or b.aktif = '1' ) and a.id_lokasi = '$lokasi' and a.id_distribusi = '$id_dis' ORDER BY a.id_meja ASC");
         

        foreach (Cart::content() as $c) {
            if ($c->qty > 1) {
                for ($x = 0; $x < $c->qty; $x++) {
                    $data2 = [
                        'no_order' => $hasil,
                        'id_harga' => $c->id,
                        'qty' => 1,
                        'harga' => $c->price,
                        'request' => $c->options->req,
                        'id_meja' => $last_meja->id_meja,
                        'id_distribusi' => $id_dis,
                        'selesai' => 'dimasak',
                        'id_lokasi' => $lokasi,
                        'tgl' => date('Y-m-d'),
                        'admin' => Auth::user()->nama,
                        'j_mulai' => date('Y-m-d H:i:s'),
                        'aktif' => '1',
                        'ongkir' => $ongkir,
                        'orang' => $orang,
                    ];
                    Orderan::create($data2);
                }
            } else {
                $data2 = [
                    'no_order' => $hasil,
                    'id_harga' => $c->id,
                    'qty' => $c->qty,
                    'harga' => $c->price,
                    'request' => $c->options->req,
                    'id_meja' => $last_meja->id_meja,
                    'id_distribusi' => $id_dis,
                    'selesai' => 'dimasak',
                    'id_lokasi' => $lokasi,
                    'tgl' => date('Y-m-d'),
                    'admin' => Auth::user()->nama,
                    'j_mulai' => date('Y-m-d H:i:s'),
                    'aktif' => '1',
                    'ongkir' => $ongkir,
                    'orang' => $orang,
                ];
                Orderan::create($data2);
            }
        }


        Cart::destroy();
        return redirect()->route('meja');
    }
}
