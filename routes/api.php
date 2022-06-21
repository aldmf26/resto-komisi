<?php

use App\Models\Dp;
use App\Models\Absen;
use App\Models\Orderan;
use Illuminate\Http\Request as r;
use Illuminate\Support\Facades\Route;
use App\Models\Transaksi;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use App\Models\Mencuci;
use App\Models\Order2;
use App\Models\Denda;
use App\Models\Tips;
use App\Models\Kasbon;
use App\Models\Voucher;
use App\Models\Discount;
use App\Models\Harga;
use App\Models\Menu;
use App\Models\Karyawan;
use App\Models\Users;
use App\Models\Permission;
use App\Models\Kategori;
use App\Models\Ctt_driver;
use App\Models\Voucher_hapus;
use App\Models\Tb_hapus_invoice;
use App\Models\Point_kerja;
use App\Models\Jurnal;
use App\Models\Handicap;
use App\Models\Jumlah_orang;
use App\Models\Persentase_kom;
use App\Models\Gaji;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('tb_order', function (r $b) {
    foreach ($b->all() as $t) {
        $data = [
            'no_order' => $t['no_order'],
            'id_harga' => $t['id_harga'],
            'qty' => $t['qty'],
            'harga' => $t['harga'],
            'tambahan' => $t['tambahan'],
            'page' => $t['page'],
            'id_meja' => $t['id_meja'],
            'selesai' => $t['selesai'],
            'id_lokasi' => $t['id_lokasi'],
            'pengantar' => $t['pengantar'],
            'tgl' => $t['tgl'],
            'void' => $t['void'],
            'round' => $t['round'],
            'alasan' => $t['alasan'],
            'nm_void' => $t['nm_void'],
            'j_mulai' => $t['j_mulai'],
            'j_selesai' => $t['j_selesai'],
            'admin' => $t['admin'],
            'diskon' => $t['diskon'],
            'wait' => $t['wait'],
            'aktif' => $t['aktif'],
            'id_koki1' => $t['id_koki1'],
            'id_koki2' => $t['id_koki2'],
            'id_koki3' => $t['id_koki3'],
            'ongkir' => $t['ongkir'],
            'id_distribusi' => $t['id_distribusi'],
            'orang' => $t['orang'],
            'no_checker' => $t['no_checker'],
            'print' => 'Y',
            'copy_print ' => 'Y',
            'request' => $t['request2'],
            'voucher' => $t['voucher']
        ];
        Orderan::create($data);
    }
    
});


Route::post('tb_transaksi', function (r $b) {
    foreach ($b->all() as $t) {
        $data = [
            'tgl_transaksi' => $t['tgl_transaksi'],
        'no_order' => $t['no_order'],
        'total_orderan' => $t['total_orderan'],
        'discount' => $t['discount'],
        'voucher' => $t['voucher'],
        'dp' => $t['dp'],
        'gosen' => $t['gosen'],
        'total_bayar' => $t['total_bayar'],
        'admin' => $t['admin'],
        'round' => $t['round'],
        'id_lokasi' => $t['id_lokasi'],
        'cash' => $t['cash'],
        'd_bca' => $t['d_bca'],
        'k_bca' => $t['k_bca'],
        'd_mandiri' => $t['d_mandiri'],
        'k_mandiri' => $t['k_mandiri'],
        'ongkir' => $t['ongkir'],
        'service' => $t['service'],
        'tax' => $t['tax'],
        ];
        Transaksi::create($data);
    }

});
Route::post('tb_hapus_invoice', function (r $b) {
    foreach ($b->all() as $t) {
        $data = [
            'no_order' => $t['no_order'],
            'tgl_order' => $t['tgl_order'],
            'alasan' => $t['alasan'],
            'nominal_invoice' => $t['nominal_invoice'],
            'id_lokasi' => $t['id_lokasi'],
            'meja' => $t['meja'],
            'admin' => $t['admin'],

        ];
        Tb_hapus_invoice::create($data);
    }
});

Route::post('tb_absen', function (r $b) {
    foreach ($b->all() as $t) {
        $data = [
            'id_karyawan' => $t['id_karyawan'],
            'status' => $t['status'],
            'tgl' => $t['tgl'],
            'id_lokasi' => $t['id_lokasi'],
        ];
        Absen::create($data);
    }
});

Route::post('tb_mencuci', function (r $b) {
    foreach ($b->all() as $t) {
        $data = [
            'nm_karyawan' => $t['nm_karyawan'],
            'id_ket' => $t['id_ket'],
            'j_awal' => $t['j_awal'],
            'j_akhir' => $t['j_akhir'],
            'tgl' => $t['tgl'],
            'admin' => $t['admin'],
        ];
        Mencuci::create($data);
    }
});

Route::post('tb_voucherUpdate', function (r $b) {
    foreach ($b->all() as $t) {
        $kode = $t['kode'];
        $terpakai = $t['terpakai'];
        if($terpakai == 'belum') {
            Voucher::where('kode', $kode)->update(['terpakai' => 'belum', 'updated_at' => $t["updated_at"]]);
        } else {
            Voucher::where('kode', $kode)->update(['terpakai' => 'sudah', 'updated_at' => $t["updated_at"]]);
        }
    }
});

Route::post('tb_order2', function (r $t) {
    foreach ($t->all() as  $b) {
        $data = [
            'no_order' =>  $b['no_order'],
            'no_order2' =>  $b['no_order2'],
            'id_harga' =>  $b['id_harga'],
            'qty' => $b['qty'],
            'harga' => $b['harga'],
            'tgl' => $b['tgl'],
            'id_lokasi' => $b['id_lokasi'],
            'admin' => $b['admin'],
            'id_distribusi' => $b['id_distribusi'],
            'id_meja' => $b['id_meja'],
        ];
        Order2::insert($data);
    }
});

Route::post('tb_denda', function (r $b) {
    foreach ($b->all() as $t) {
        $data = [
            'nama' => $t['nama'],
            'alasan' =>  $t['alasan'],
            'nominal' =>  $t['nominal'],
            'tgl' =>  $t['tgl'],
            'id_lokasi' =>  $t['id_lokasi'],
            'admin' => $t['admin'],
        ];
        Denda::create($data);
    }
});

Route::post('tips_tb', function (r $b) {
    foreach ($b->all() as $t) {
        $data = [
            'tgl' => $t['tgl'],
            'admin' =>  $t['admin'],
            'nominal' =>  $t['nominal'],
        ];
        Tips::create($data);
    }
});

Route::post('tb_kasbon', function (r $b) {
    foreach ($b->all() as $t) {
        $data = [
            'tgl' => $t['tgl'],
            'nm_karyawan' => $t['nm_karyawan'],
            'admin' =>  $t['admin'],
            'nominal' =>  $t['nominal'],
        ];
        Kasbon::create($data);
    }
});

Route::post('tb_driver', function (r $b) {
    foreach ($b->all() as $t) {
        $data = [
            'no_order' => $t['no_order'],
            'nm_driver' => $t['nm_driver'],
            'nominal' =>  $t['nominal'],
            'tgl' =>  $t['tgl'],
            'admin' =>  $t['admin'],
        ];
        Ctt_driver::create($data);
    }
});



// data download / get dari lokal
Route::get('voucher', function () {
    $data = [
        'voucher' => Voucher::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});
Route::get('voucher_tkmr', function () {
    $data = [
        'voucher' => Voucher::where('lokasi','1')->get(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});
Route::get('voucher_sdb', function () {
    $data = [
        'voucher' => Voucher::where('lokasi','2')->get(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});

Route::get('discount', function () {
    $data = [
        'disount' => Discount::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});

Route::get('menu_tb', function () {
    $data = [
        'menu' => Menu::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});
Route::get('harga_tb', function () {
    $data = [
        'harga' => Harga::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});

Route::get('karyawan_tb', function () {
    $data = [
        'karyawan' => Karyawan::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});

Route::get('handicap', function () {
    $data = [
        'handicap' => Handicap::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});

Route::get('kategori_menu', function () {
    $data = [
        'kategori_menu' => Kategori::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});
Route::get('tb_jumlah_orang', function () {
    $data = [
        'tb_jumlah_orang' => Jumlah_orang::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});
Route::get('persentase_komisi', function () {
    $data = [
        'persentase_komisi' => Persentase_kom::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});
Route::get('gaji', function () {
    $data = [
        'gaji' => Gaji::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});

Route::get('users', function () {
    $data = [
        'users' => Users::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});
Route::get('tb_permission', function () {
    $data = [
        'tb_permission' => Permission::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});
Route::get('tb_voucher_hapus', function () {
    $data = [
        'tb_voucher_hapus' => Voucher_hapus::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});

Route::get('point_kerja', function () {
    $data = [
        'point_kerja' => Point_kerja::all(),
    ];
    return response()->json($data, HttpFoundationResponse::HTTP_OK);
});
