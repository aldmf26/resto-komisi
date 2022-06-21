<?php

namespace App\Http\Controllers;

use App\Models\Aktiva;
use App\Models\Akun;
use App\Models\Atk;
use App\Models\Jurnal;
use App\Models\Karyawan;
use App\Models\KelPeralatan;
use App\Models\Peralatan;
use App\Models\PostCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Str;


class AccountingController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => 'Akun',
            'logout' => $request->session()->get('logout'),
            'akun' => Akun::join('tb_kategori_akun', 'tb_kategori_akun.id_kategori', '=', 'tb_akun.id_kategori')->get()
        ];
        return view('accounting.home', $data);
    }

    public function dashboard(Request $request)
    {
        $data = [
            'title' => 'Accounting Takemori',
            'logout' => $request->session()->get('logout'),
            'akun' => Akun::join('tb_kategori_akun', 'tb_kategori_akun.id_kategori', '=', 'tb_akun.id_kategori')->get()
        ];
        return view('accounting.dashboard', $data);
    }

    public function akun(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 21)->first();
        if (empty($id_menu)) {
            return back();
        } else {
            if (Auth::user()->jenis == 'adm') {
                $data = [
                    'title' => 'Akun',
                    'logout' => $request->session()->get('logout'),
                    'akun' => Akun::join('tb_kategori_akun', 'tb_kategori_akun.id_kategori', '=', 'tb_akun.id_kategori')->where('id_lokasi', $request->acc)->orderBy('no_akun', 'asc')->get(),

                ];

                return view('accounting.accounting', $data);
            } else {
                return back();
            }
        }
    }

    public function addPostCenter(Request $request)
    {
        $id_akun = $request->id_akun;
        $nm_post = $request->nm_post;
        $id_lokasi = $request->id_lokasi;

        $data = [
            'id_akun' => $id_akun,
            'nm_post' => $nm_post,
            'id_lokasi' => $id_lokasi,
        ];
        PostCenter::create($data);
        return redirect()->route('akun', ['acc' => $id_lokasi])->with('sukses', 'Berhasil tambah post center');
    }

    public function get_data_post_center(Request $request)
    {
        $id_akun = $request->id_akun;
        $id_lokasi = $request->id_lokasi;

        $data = [
            'post_center' => PostCenter::where('id_akun', $id_akun)->get()

        ];

        return view('accounting.postCenter', $data);
    }

    public function getProjek(Request $request)
    {
        $proyek = $request->id_projek;
        $aktiva = DB::select("SELECT j.id_proyek, sum(j.debit) as kredit1 from tb_jurnal as j where j.id_proyek = '$proyek' group by j.id_proyek");
        $output = [];
        foreach ($aktiva as $k) {
            if ($k->id_proyek == "PR022") {
                $output['b_kredit'] = '0';
            } else {
                $output['b_kredit'] = $k->kredit1;
            }
        }
        echo json_encode($output);
    }

    public function getPost(Request $request)
    {
        $id_pilih = $request->id_pilih;
        $post = PostCenter::where('id_akun', $id_pilih)->get();
        // dd($post);
        echo "<option value=''>Pilih post center</option>";
        foreach ($post as $k) {
            echo "<option value='" . $k->id_post . "'>" . $k->nm_post . "</option>";
        }
    }

    public function getPost2(Request $request)
    {
        $id_pilih = $request->id_pilih;
        $post = DB::select("SELECT a.*
        FROM tb_post_center AS a 
        WHERE a.id_akun = '$id_pilih'  AND a.nm_post NOT IN(SELECT b.barang FROM aktiva AS b)");
        echo "<option value=''>Pilih post center</option>";
        foreach ($post as $k) {
            echo "<option value='" . $k->id_post . "'>" . $k->nm_post . "</option>";
        }
    }

    public function addAkun(Request $request)
    {

        $data = [
            'kd_akun' => $request->kd_akun,
            'no_akun' => $request->no_akun,
            'nm_akun' => $request->nm_akun,
            'id_kategori' => $request->id_kategori,
            'id_lokasi' => $request->id_lokasi
        ];

        Akun::create($data);

        return redirect()->route('akun', ['acc' => $request->id_lokasi])->with('sukses', 'Data berhasil Ditambah');
    }

    public function editAkun(Request $request)
    {

        $data = [
            'kd_akun' => $request->kd_akun,
            'no_akun' => $request->no_akun,
            'nm_akun' => $request->nm_akun,
            'id_kategori' => $request->id_kategori,
        ];

        Akun::where('id_akun', $request->id_akun)->update($data);

        return redirect()->route('akun', ['acc' => $request->id_lokasi])->with('sukses', 'Data berhasil Diubah');
    }

    public function exportAkun(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1:D4')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        // lebar kolom
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);

        $sheet
            ->setCellValue('A1', 'NO AKUN')
            ->setCellValue('B1', 'AKUN ' . $request->id_lokasi == 1 ? 'TAKEMORI' : 'SOONDOBU')
            ->setCellValue('C1', 'KODE AKUN')
            ->setCellValue('D1', 'ID KATEGORI')
            ->setCellValue('E1', 'ID LOKASI');
        $no = 2;
        $data = Akun::join('tb_kategori_akun', 'tb_kategori_akun.id_kategori', '=', 'tb_akun.id_kategori')->where('id_lokasi', $request->id_lokasi)->orderBy('no_akun', 'asc')->get();
        foreach ($data as $k) {
            $sheet
                ->setCellValue('A' . $no, $k->no_akun)
                ->setCellValue('B' . $no, $k->nm_akun)
                ->setCellValue('C' . $no, $k->kd_akun)
                ->setCellValue('D' . $no, $k->id_kategori)
                ->setCellValue('E' . $no, $request->id_lokasi);
            $no++;
        }
        $writer = new Xlsx($spreadsheet);
        $style = [
            'borders' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];

        // tambah style
        $batas = count($data) + 1;
        $sheet->getStyle('A1:E' . $batas)->applyFromArray($style);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data Akun.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function importAkun(Request $request)
    {
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        // $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
        // $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $lokasi = $request->id_lokasi;
        $numrow = 1;
        foreach ($sheet as $row) {
            if ($numrow > 1) {
                $data = [
                    'id_lokasi' => $row['E'],
                    'kd_akun' => $row['C'],
                    'no_akun' => $row['A'],
                    'nm_akun' => $row['B'],
                    'id_kategori' => $row['D'],
                ];
                Akun::create($data);
            }
            $numrow++;
        }
        return redirect()->route('akun', ['acc' => $lokasi])->with('sukses', 'Data berhasil Diimport');
    }

    public function jPemasukan(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 32)->first();
        if (empty($id_menu)) {
            return back();
        } else {
            if (Auth::user()->jenis == 'adm') {
                $tglDari = $request->dari;
                $tglSampai = $request->sampai;
                if (empty($tglDari)) {
                    $dari = date('Y-m-1');
                    $sampai = date('Y-m-d');
                } else {
                    $dari = $tglDari;
                    $sampai = $tglSampai;
                }
                $id_lokasi = $request->acc;
                $data = [
                    'title' => 'Jurnal Pemasukan',
                    'logout' => $request->session()->get('logout'),
                    'jurnal' => Jurnal::join('tb_akun', 'tb_akun.id_akun', '=', 'tb_jurnal.id_akun')->where([
                        ['id_buku', 1],
                        ['tb_jurnal.id_lokasi', $id_lokasi]
                    ])->whereBetween('tgl', [$dari, $sampai])->orderBy('tb_jurnal.id_jurnal', 'DESC')->get(),
                ];

                return view('accounting.jPemasukan', $data);
            } else {
                return back();
            }
        }
    }

    public function jPengeluaran(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 32)->first();
        if (empty($id_menu)) {
            return back();
        } else {
            if (Auth::user()->jenis == 'adm') {
                $tglDari = $request->dari;
                $tglSampai = $request->sampai;
                if (empty($tglDari)) {
                    $dari = date('Y-m-1');
                    $sampai = date('Y-m-d');
                } else {
                    $dari = $tglDari;
                    $sampai = $tglSampai;
                }
                $data = [
                    'title' => 'Jurnal Pengeluaran',
                    'logout' => $request->session()->get('logout'),
                    'akun' => Akun::where('id_lokasi', $request->acc)->get(),
                    'jurnal' => Jurnal::join('tb_akun', 'tb_akun.id_akun', '=', 'tb_jurnal.id_akun')->where([['tb_jurnal.id_lokasi', $request->get('acc')], ['tb_jurnal.id_buku', 3]])->whereBetween('tgl', [$dari, $sampai])->orderBy('tb_jurnal.id_jurnal', 'DESC')->get(),
                    'satuan' => DB::table('tb_satuan')->get(),
                    'peralatan' => KelPeralatan::all(),
                    'nm_penanggung' => DB::table('tb_penanggung_jawab')->get(),
                    'lokasi' => DB::table('tb_lokasi')->get(),
                    'aktiva' => DB::table('tb_kelompok_aktiva')->get(),
                ];

                return view('accounting.jPengeluaran', $data);
            } else {
                return back();
            }
        }
    }

    public function addjPengeluaran(Request $request)
    {

        $kd_gabungan = 'RST' . date('dmy') . strtoupper(Str::random(3));
        // dd($kd_gabungan);
        $tgl = $request->tgl;
        $id_akun = $request->id_akun;
        $metode = $request->metode;
        $ket = $request->keterangan;
        $ket2 = $request->ket2;
        $ttl_rp = $request->ttl_rp;
        $id_proyek = $request->id_proyek;
        $admin = Auth::user()->nama;
        $id_satuan = $request->id_satuan;
        $qty = $request->qty;
        $id_post = $request->id_post_center;
        $no_id = $request->no_id;
        $id_lokasi = $request->id_lokasi;

        $month = date('m', strtotime($tgl));
        $year = date('Y', strtotime($tgl));

        $get_kode_akun = Akun::where('id_akun', $id_akun)->get()[0];
        $kode_akun = Jurnal::where('id_akun', $id_akun)->whereMonth('tgl', $month)->whereYear('tgl', $year)->count();

        if ($kode_akun == 0) {
            $kode_akun = 1;
        } else {
            $kode_akun += 1;
        }

        $get_kd_metode = Akun::where('id_akun', $metode)->get()[0];
        $kode_metode = Jurnal::where('id_akun', $metode)->whereMonth('tgl', $month)->whereYear('tgl', $year)->count();

        if ($kode_metode == 0) {
            $kode_metode = 1;
        } else {
            $kode_metode += 1;
        }

        $total = 0;

        for ($count = 0; $count < count($ttl_rp); $count++) {
            $total += $ttl_rp[$count];
        }

        $data_metode = [
            'id_buku' => 3,
            'id_akun' => $metode,
            'id_customer' => '3',
            'kd_gabungan' => $kd_gabungan,
            'no_nota' => $get_kd_metode->kd_akun . date('my', strtotime($tgl)) . '-' . $kode_metode,
            'kredit' => $total,
            'tgl' => $tgl,
            'tgl_input' => date('Y-m-d H:i:s'),
            'admin' => $admin,
            'jenis' => 'biaya',
            'id_lokasi' => $id_lokasi,
            // 'id_post' => $id_post

        ];

        Jurnal::create($data_metode);

        for ($i = 0; $i < count($ttl_rp); $i++) {
            // $total += $ttl_rp[$i];
            $data_jurnal = [
                'id_buku' => 3,
                'id_akun' => $id_akun,
                'id_customer' => '3',
                'kd_gabungan' => $kd_gabungan,
                'id_proyek' => $id_proyek,
                'no_nota' => $get_kode_akun->kd_akun . date('my', strtotime($tgl)) . '-' . $kode_akun,
                'debit' => $ttl_rp[$i],
                'ket' => $ket[$i],
                'ket2' => $ket2[$i],
                'tgl' => $tgl,
                'tgl_input' => date('Y-m-d H:i:s'),
                'admin' => $admin,
                'qty' => $qty[$i],
                'no_urutan' => $no_id[$i],
                'id_satuan' => $id_satuan[$i],
                // 'rp_beli' => $rp_beli[$i],
                'ttl_rp' => $ttl_rp[$i],
                'jenis' => 'biaya',
                'id_lokasi' => $id_lokasi,
            ];

            Jurnal::create($data_jurnal);
            // $kode_akun++;
        }

        return redirect()->route('jPengeluaran', ['acc' => $id_lokasi])->with('sukses', 'Data berhasil Ditambah');
    }

    public function addjAtk(Request $request)
    {
        $kd_gabungan = 'RST' . date('dmy') . strtoupper(Str::random(3));
        // dd($kd_gabungan);
        $tgl = $request->tgl;
        $id_akun = $request->id_akun;
        $metode = $request->metode;
        $ket = $request->keterangan;
        $ket2 = $request->ket2;
        $ttl_rp = $request->ttl_rp;
        $id_proyek = $request->id_proyek;
        $admin = Auth::user()->nama;
        $id_satuan = $request->id_satuan;
        $qty = $request->qty;
        $id_post = $request->id_post_center;
        $no_id = $request->no_id;

        $id_lokasi = $request->id_lokasi;

        $month = date('m', strtotime($tgl));
        $year = date('Y', strtotime($tgl));

        $get_kode_akun = Akun::where('id_akun', $id_akun)->get()[0];
        $kode_akun = Jurnal::where('id_akun', $id_akun)->whereMonth('tgl', $month)->whereYear('tgl', $year)->count();

        if ($kode_akun == 0) {
            $kode_akun = 1;
        } else {
            $kode_akun += 1;
        }

        $get_kd_metode = Akun::where('id_akun', $metode)->get()[0];
        $kode_metode = Jurnal::where('id_akun', $metode)->whereMonth('tgl', $month)->whereYear('tgl', $year)->count();

        if ($kode_metode == 0) {
            $kode_metode = 1;
        } else {
            $kode_metode += 1;
        }

        $total = 0;
        for ($i = 0; $i < count($ttl_rp); $i++) {
            $total += $ttl_rp[$i];
        }

        $data_metode = [
            'id_buku' => 3,
            'id_akun' => $metode,
            'id_customer' => '3',
            'kd_gabungan' => $kd_gabungan,
            'no_nota' => $get_kd_metode->kd_akun . date('my', strtotime($tgl)) . '-' . $kode_metode,
            'kredit' => $total,
            'tgl' => $tgl,
            'tgl_input' => date('Y-m-d H:i:s'),
            'admin' => $admin,
            'jenis' => 'atk',
            'id_lokasi' => $id_lokasi,
            // 'id_post' => $id_post

        ];

        Jurnal::create($data_metode);

        for ($i = 0; $i < count($ttl_rp); $i++) {
            // $total += $ttl_rp[$i];
            $data_jurnal = [
                'id_buku' => 3,
                'id_akun' => $id_akun,
                'id_customer' => '3',
                'kd_gabungan' => $kd_gabungan,
                'id_proyek' => $id_proyek,
                'no_nota' => $get_kode_akun->kd_akun . date('my', strtotime($tgl)) . '-' . $kode_akun,
                'debit' => $ttl_rp[$i],
                'ket' => $ket[$i],
                'ket2' => $ket2[$i],
                'tgl' => $tgl,
                'tgl_input' => date('Y-m-d H:i:s'),
                'admin' => $admin,
                'qty' => $qty[$i],
                'no_urutan' => $no_id[$i],
                'id_satuan' => $id_satuan[$i],
                // 'rp_beli' => $rp_beli[$i],
                'ttl_rp' => $ttl_rp[$i],
                'jenis' => 'atk',
                'id_lokasi' => $id_lokasi,
            ];

            Jurnal::create($data_jurnal);
            // $kode_akun++;
        }

        for ($i = 0; $i < count($ket); $i++) {

            $nota = Atk::select("SELECT MAX(a.no_nota) as nota
            FROM tb_atk AS a");

            if (empty($nota->nota)) {
                $no = '1001';
            } else {
                $no = $nota->nota + 1;
            }
            $data_atk = [
                'no_nota' => $no,
                'tgl' => $tgl,
                'nm_barang' => $ket2[$i],
                'debit_atk' => $ttl_rp[$i],
                'qty_debit' => $qty[$i],
                'id_satuan' => $id_satuan[$i],
                'id_lokasi' => $id_lokasi

            ];
            Atk::create($data_atk);
        }

        return redirect()->route('jPengeluaran', ['acc' => $id_lokasi])->with('sukses', 'Data berhasil Ditambah');
    }

    public function addjPeralatan(Request $request)
    {
        $kd_gabungan = 'RST' . date('dmy') . strtoupper(Str::random(3));
        // dd($kd_gabungan);
        $tgl = $request->tgl;
        $id_akun = $request->id_akun;
        $metode = $request->metode;
        $nm_barang = $request->nm_barang;
        $ttl_rp = $request->ttl_rp;
        $total3 = $request->total;
        $admin = Auth::user()->nama;
        $id_satuan = $request->id_satuan;
        $qty = $request->qty;
        $no_urutan = $request->no_id;
        $id_lokasi = $request->id_lokasi;
        $id_penanggung = $request->id_penanggung;
        $id_kelompok = $request->id_kelompok;

        $month = date('m', strtotime($tgl));
        $year = date('Y', strtotime($tgl));

        $get_kode_akun = Akun::where('id_akun', $id_akun)->get()[0];
        $kode1 = DB::selectOne("SELECT a.id_jurnal,a.no_nota, SUBSTRING(a.no_nota,-1) AS nota2
        FROM tb_jurnal AS a
        WHERE a.id_akun = '$id_akun' AND MONTH(a.tgl) = '$month' AND YEAR(a.tgl) = '$year'
        GROUP BY a.no_nota
        ORDER BY SUBSTRING(a.no_nota,-1) DESC");

        if (empty($kode1)) {
            $kode_akun = 1;
        } else {
            $kode_akun = $kode1->nota2 + 1;
        }

        $get_kd_metode = Akun::where('id_akun', $metode)->get()[0];
        $kode = DB::selectOne("SELECT a.id_jurnal,a.no_nota, SUBSTRING(a.no_nota,-1) AS nota2
        FROM tb_jurnal AS a
        WHERE a.id_akun = '$metode' AND MONTH(a.tgl) = '$month' AND YEAR(a.tgl) = '$year'
        GROUP BY a.no_nota
        ORDER BY SUBSTRING(a.no_nota,-1) DESC
        ");

        if (empty($kode)) {
            $kode_metode = 1;
        } else {
            $kode_metode = $kode->nota2 + 1;
        }

        $total = 0;
        for ($count = 0; $count < count($ttl_rp); $count++) {
            $total += $ttl_rp[$count];
        }

        $data_metode = [
            'id_buku' => 3,
            'id_akun' => $metode,
            'id_customer' => '3',
            'kd_gabungan' => $kd_gabungan,
            'no_nota' => $get_kd_metode->kd_akun . date('my', strtotime($tgl)) . '-' . $kode_metode,
            'kredit' => $total3,
            'tgl' => $tgl,
            'tgl_input' => date('Y-m-d H:i:s'),
            'admin' => $admin,
            'jenis' => 'peralatan',
            'id_lokasi' => $id_lokasi,
            // 'id_post' => $id_post

        ];

        Jurnal::create($data_metode);

        for ($i = 0; $i < count($ttl_rp); $i++) {
            $data_jurnal = [
                'id_buku' => 3,
                'id_customer' => '3',
                'id_akun' => $id_akun,
                'kd_gabungan' => $kd_gabungan,
                'no_nota' => $get_kode_akun->kd_akun . date('my', strtotime($tgl)) . '-' . $kode_akun,
                'debit' => $ttl_rp[$i],
                'ket' => 'pembelian ' . ' ' . $nm_barang[$i],
                'tgl' => $tgl,
                'tgl_input' => date('Y-m-d H:i:s'),
                'admin' => $admin,
                'qty' => $qty[$i],
                'id_satuan' => $id_satuan[$i],
                'ttl_rp' => $ttl_rp[$i],
                'no_urutan' => $no_urutan[$i],
                'jenis' => 'peralatan',
                'id_lokasi' => $id_lokasi
            ];
            $id_kredit = Jurnal::create($data_jurnal);
            $id_kredit = $id_kredit->id;
        }

        for ($x = 0; $x < sizeof($nm_barang); $x++) {

            $kelompok = KelPeralatan::where('id_kelompok', $id_kelompok[$x])->first();

            if ($kelompok->satuan == 'Bulan') {
                $susut = $kelompok->umur;
            } else {
                $susut = $kelompok->umur * 12;
            }
            $b_penyusutan = $ttl_rp[$x] / $susut;

            $data_barang = [
                'tgl' => $tgl,
                'id_kelompok_peralatan' =>  $id_kelompok[$x],
                'barang' => $nm_barang[$x],
                'qty' => $qty[$x],
                'debit' => $ttl_rp[$x],
                'lokasi' => $id_lokasi[$x],
                'id_satuan' => $id_satuan[$x],
                'penanggung_jawab' => $id_penanggung[$x],
                'id_peralatan_kredit' => $id_kredit,
                'b_penyusutan' =>  $b_penyusutan,

            ];
            Peralatan::create($data_barang);
        }
        return redirect()->route('jPengeluaran', ['acc' => $id_lokasi])->with('sukses', 'Data berhasil Ditambah');
    }

    public function addjAktiva(Request $request)
    {
        $kd_gabungan = 'RST' . date('dmy') . strtoupper(Str::random(3));
        // dd($kd_gabungan);
        $tgl = $request->tgl;
        $id_akun = $request->id_akun;
        $metode = $request->metode;
        $ttl_rp = $request->ttl_rp;
        $total = $request->total;
        $admin = Auth::user()->nama;
        $rp_satuan = $request->rp_satuan;
        $qty = $request->qty;
        $ppn = $request->ppn;
        $id_lokasi = $request->id_lokasi;
        $id_post = $request->id_post;
        $ket2 = $request->ket;
        $no_urutan = $request->no_id;
        $id_satuan = $request->id_satuan;

        $post_center = DB::table('tb_post_center')->where('id_post')->first();

        $ket3 = empty($post_center->nm_post) ? $ket2 : $post_center->nm_post;

        $month = date('m', strtotime($tgl));
        $year = date('Y', strtotime($tgl));

        $get_kode_akun = Akun::where('id_akun', $id_akun)->get()[0];
        $kode1 = DB::selectOne("SELECT a.id_jurnal,a.no_nota, SUBSTRING(a.no_nota,-1) AS nota2
        FROM tb_jurnal AS a
        WHERE a.id_akun = '$id_akun' AND MONTH(a.tgl) = '$month' AND YEAR(a.tgl) = '$year'
        GROUP BY a.no_nota
        ORDER BY SUBSTRING(a.no_nota,-1) DESC");

        if (empty($kode1)) {
            $kode_akun = 1;
        } else {
            $kode_akun = $kode1->nota2 + 1;
        }

        $get_kd_metode = Akun::where('id_akun', $metode)->get()[0];
        $kode = DB::selectOne("SELECT a.id_jurnal,a.no_nota, SUBSTRING(a.no_nota,-1) AS nota2
        FROM tb_jurnal AS a
        WHERE a.id_akun = '$metode' AND MONTH(a.tgl) = '$month' AND YEAR(a.tgl) = '$year'
        GROUP BY a.no_nota
        ORDER BY SUBSTRING(a.no_nota,-1) DESC
        ");

        if (empty($kode)) {
            $kode_metode = 1;
        } else {
            $kode_metode = $kode->nota2 + 1;
        }

        $total = $ttl_rp;

        $get_kode_akun = Akun::where('id_akun', $id_lokasi == 1 ? 100 : 141)->get()[0];
        $kode_ppn = Jurnal::where('id_akun', $id_lokasi == 1 ? 100 : 141)->whereMonth('tgl', $month)->whereYear('tgl', $year)->count();

        if ($kode_ppn == 0) {
            $kode_ppn = 1;
        } else {
            $kode_ppn += 1;
        }

        $data_metode = [
            'id_buku' => 3,
            'id_akun' => $metode,
            'id_customer' => '3',
            'kd_gabungan' => $kd_gabungan,
            'no_nota' => $get_kd_metode->kd_akun . date('my', strtotime($tgl)) . '-' . $kode_metode,
            'kredit' => $total,
            'tgl' => $tgl,
            'tgl_input' => date('Y-m-d H:i:s'),
            'admin' => $admin,
            'jenis' => 'aktiva',
            'id_lokasi' => $id_lokasi,
            'no_urutan' => $no_urutan,
            // 'id_post' => $id_post

        ];

        Jurnal::create($data_metode);

        if (empty($ppn)) {
        } else {
            $data_jurnal = [
                'id_buku' => 3,
                'id_akun' => $id_lokasi == 1 ? 100 : 141,
                'id_customer' => '3',
                'kd_gabungan' => $kd_gabungan,
                'no_nota' => $get_kode_akun->kd_akun . date('my', strtotime($tgl)) . '-' . $kode_akun,
                'debit' => $ppn,
                'tgl' => $tgl,
                'ttl_rp' => $total,
                'tgl_input' => date('Y-m-d H:i:s'),
                'admin' => $admin,
                'no_urutan' => $no_urutan,
                // 'rp_beli' => $rp_beli[$i],
                'jenis' => 'aktiva',
                'id_lokasi' => $id_lokasi,
            ];

            Jurnal::create($data_jurnal);
            $kode_akun++;
        }

        $data_jurnal = [
            'id_buku' => 3,
            'id_akun' => $id_akun,
            'id_customer' => '3',
            'kd_gabungan' => $kd_gabungan,
            'no_nota' => $get_kode_akun->kd_akun . date('my', strtotime($tgl)) . '-' . $kode_akun,
            'debit' => $rp_satuan * $qty,
            'tgl' => $tgl,
            'ket' => $ket3,
            'ttl_rp' => $ttl_rp,
            'tgl_input' => date('Y-m-d H:i:s'),
            'admin' => $admin,
            'qty' => $qty,
            'no_urutan' => $no_urutan,
            // 'rp_beli' => $rp_beli[$i],
            'jenis' => 'aktiva',
            'id_lokasi' => $id_lokasi,
        ];

        Jurnal::create($data_jurnal);

        $id_kelompok = $request->id_kelompok;
        $id = $id_kelompok;
        $kelompok = DB::table('tb_kelompok_aktiva')->where('id_kelompok', $id)->first();
        $susut = $kelompok->tarif;
        $satuan = DB::table('tb_satuan')->where('id', $id_satuan)->first();
        $aktiva = [
            'id_lokasi' => $id_lokasi,
            'barang' => $ket3,
            'debit_aktiva' => $rp_satuan * $qty,
            'tgl' => $tgl,
            'qty' => $qty,
            'satuan' => $satuan->n,
            'nota' => $get_kode_akun->kd_akun . date('my', strtotime($tgl)) . '-' . $kode_akun,
            'b_penyusutan' => (($rp_satuan * $qty) * $susut) / 12,
        ];

        Aktiva::create($aktiva);

        return redirect()->route('jPengeluaran', ['acc' => $id_lokasi])->with('sukses', 'Data berhasil Ditambah');
    }

    public function deletejPengeluaran(Request $request)
    {
        Jurnal::where('kd_gabungan', $request->kd_gabungan)->delete();
        return redirect()->route('jPengeluaran', ['acc' => $request->id_lokasi])->with('error', 'Data berhasil dihapus');
    }

    public function exportJPengeluaran(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        $jurnal = DB::select("SELECT a.* ,b.no_akun, b.nm_akun, c.nm_post, d.n, a.admin
        FROM tb_jurnal as a 
        left join tb_akun as b on b.id_akun = a.id_akun 
        left join tb_post_center AS c ON c.id_post = a.id_post
        left join tb_satuan AS d ON d.id = a.id_satuan
        WHERE a.id_buku IN('3','4','5') and a.tgl between '$dari' and '$sampai'  order by a.no_urutan  ASC;");

        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('Jurnal Pengeluaran');
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'Id');
        $spreadsheet->getActiveSheet()->setCellValue('B1', 'Tanggal');
        $spreadsheet->getActiveSheet()->setCellValue('C1', 'D');
        $spreadsheet->getActiveSheet()->setCellValue('D1', 'M');
        $spreadsheet->getActiveSheet()->setCellValue('E1', 'Y');
        $spreadsheet->getActiveSheet()->setCellValue('F1', 'No Nota');
        $spreadsheet->getActiveSheet()->setCellValue('G1', 'No id');
        $spreadsheet->getActiveSheet()->setCellValue('H1', 'Id Akun');
        $spreadsheet->getActiveSheet()->setCellValue('I1', 'No Akun');
        $spreadsheet->getActiveSheet()->setCellValue('J1', 'Post Akun');
        $spreadsheet->getActiveSheet()->setCellValue('K1', 'Id Post Center');
        $spreadsheet->getActiveSheet()->setCellValue('L1', 'Post Center');
        $spreadsheet->getActiveSheet()->setCellValue('M1', 'Keterangan');
        $spreadsheet->getActiveSheet()->setCellValue('N1', 'Qty');
        $spreadsheet->getActiveSheet()->setCellValue('O1', 'Satuan');
        $spreadsheet->getActiveSheet()->setCellValue('P1', 'Debit');
        $spreadsheet->getActiveSheet()->setCellValue('Q1', 'Kredit');
        $spreadsheet->getActiveSheet()->setCellValue('R1', 'Admin');

        $style = array(
            'font' => array(
                'size' => 9
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        $spreadsheet->getActiveSheet()->getStyle('A1:R1')->applyFromArray($style);


        $yelow = array(
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'F7F700')
            )
        );

        $red = array(
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'F70000')
            )
        );

        $spreadsheet->getActiveSheet()->getStyle('A1:R1')->getAlignment()->setWrapText(true);

        // $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(23);

        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(34.73);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(9.91);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(9.64);

        $spreadsheet->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
        // $spreadsheet->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('');
        $spreadsheet->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('');
        $spreadsheet->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('0000');

        $kolom = 2;
        foreach ($jurnal as $d) {
            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $kolom, $d->id_jurnal);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $kolom, date('Y-m-d', strtotime($d->tgl)));
            $spreadsheet->getActiveSheet()->setCellValue('C' . $kolom, date('d', strtotime($d->tgl)));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $kolom, date('m', strtotime($d->tgl)));
            $spreadsheet->getActiveSheet()->setCellValue('E' . $kolom, date('Y', strtotime($d->tgl)));
            $spreadsheet->getActiveSheet()->setCellValue('F' . $kolom, $d->no_nota);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $kolom, $d->no_urutan);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $kolom, $d->id_akun);
            $spreadsheet->getActiveSheet()->setCellValue('I' . $kolom, $d->no_akun);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $kolom, $d->nm_akun);
            $spreadsheet->getActiveSheet()->setCellValue('K' . $kolom, $d->id_post);

            $spreadsheet->getActiveSheet()->setCellValue('L' . $kolom, $d->nm_post);


            $spreadsheet->getActiveSheet()->setCellValue('M' . $kolom, $d->ket);
            $spreadsheet->getActiveSheet()->setCellValue('N' . $kolom, $d->qty);
            $spreadsheet->getActiveSheet()->setCellValue('O' . $kolom, $d->n);
            $spreadsheet->getActiveSheet()->setCellValue('P' . $kolom, $d->debit);
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $kolom, $d->kredit);
            $spreadsheet->getActiveSheet()->setCellValue('R' . $kolom, $d->admin);
            $kolom++;
        }

        $border_collom = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            )
        );

        $batas = $kolom - 1;
        $spreadsheet->getActiveSheet()->getStyle('A1:R' . $batas)->applyFromArray($style);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data export jurnal all.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function exportJPemasukan(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        $jurnal = DB::select("SELECT a.* ,b.no_akun, b.nm_akun, c.nm_post, d.n, a.admin
        FROM tb_jurnal as a 
        left join tb_akun as b on b.id_akun = a.id_akun 
        left join tb_post_center AS c ON c.id_post = a.id_post
        left join tb_satuan AS d ON d.id = a.id_satuan
        WHERE a.id_buku IN('1') and a.tgl between '$dari' and '$sampai'  order by a.no_urutan  ASC;");

        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('Jurnal Pengeluaran');
        $spreadsheet->getActiveSheet()->setCellValue('A1', '#');
        $spreadsheet->getActiveSheet()->setCellValue('B1', 'Tanggal');
        $spreadsheet->getActiveSheet()->setCellValue('C1', 'D');
        $spreadsheet->getActiveSheet()->setCellValue('D1', 'M');
        $spreadsheet->getActiveSheet()->setCellValue('E1', 'Y');
        $spreadsheet->getActiveSheet()->setCellValue('F1', 'No Invoice');
        $spreadsheet->getActiveSheet()->setCellValue('G1', 'Keterangan');
        $spreadsheet->getActiveSheet()->setCellValue('H1', 'No Akun');
        $spreadsheet->getActiveSheet()->setCellValue('I1', 'Nama Akun');
        $spreadsheet->getActiveSheet()->setCellValue('J1', 'Debit');
        $spreadsheet->getActiveSheet()->setCellValue('K1', 'Kredit');

        $style = array(
            'font' => array(
                'size' => 9
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        $spreadsheet->getActiveSheet()->getStyle('A1:K1')->applyFromArray($style);


        $yelow = array(
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'F7F700')
            )
        );

        $red = array(
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'F70000')
            )
        );

        $spreadsheet->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(9.91);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(9.64);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(9.64);

        $spreadsheet->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
        // $spreadsheet->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('');
        $spreadsheet->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('');
        $spreadsheet->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('0000');

        $kolom = 2;
        $no = 1;
        $debit = 0;
        $kredit = 0;
        foreach ($jurnal as $d) {
            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $kolom, $no++);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $kolom, date('Y-m-d', strtotime($d->tgl)));
            $spreadsheet->getActiveSheet()->setCellValue('C' . $kolom, date('d', strtotime($d->tgl)));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $kolom, date('m', strtotime($d->tgl)));
            $spreadsheet->getActiveSheet()->setCellValue('E' . $kolom, date('Y', strtotime($d->tgl)));
            $spreadsheet->getActiveSheet()->setCellValue('F' . $kolom, $d->no_nota);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $kolom, $d->ket);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $kolom, $d->no_akun);
            $spreadsheet->getActiveSheet()->setCellValue('I' . $kolom, $d->nm_akun);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $kolom, $d->debit);
            $spreadsheet->getActiveSheet()->setCellValue('K' . $kolom, $d->kredit);
            $kolom++;
            $debit += $d->debit;
            $kredit += $d->kredit;
        }
        $spreadsheet->getActiveSheet()->setCellValue('A' . $kolom, 'TOTAL');
        $spreadsheet->getActiveSheet()->setCellValue('J' . $kolom, $debit);
        $spreadsheet->getActiveSheet()->setCellValue('K' . $kolom, $kredit);

        $border_collom = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            )
        );

        $batas = $kolom - 1;
        $spreadsheet->getActiveSheet()->getStyle('A1:K' . $batas+1)->applyFromArray($style);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data export jurnal all.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function lapBulanan(Request $request)
    {
        $data = [
            'title' => 'Laporan Bulanan',
            'logout' => $request->session()->get('logout'),
        ];
        return view('accounting.homepage.lapBulanan', $data);
    }

    public function neracaSaldo(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 33)->first();
        if (empty($id_menu)) {
            return back();
        } else {
            if (Auth::user()->jenis == 'adm') {
                // dd($request->acc);
                $data = [
                    'title' => 'Neraca Saldo',
                    'logout' => $request->session()->get('logout'),
                    'neracaSaldo' => DB::select("SELECT a.id_akun, b.tgl, a.nm_akun , b.debit_saldo, b.kredit_saldo
                    FROM tb_akun AS a
                    LEFT JOIN tb_neraca_saldo AS b ON b.id_akun = a.id_akun
                    WHERE a.id_kategori not IN ('3','4') AND a.id_lokasi = '$request->acc'"),
                    'lokasi' => DB::table('tb_lokasi')->get(),
                ];
                return view('accounting.neracaSaldo', $data);
            } else {
                return back();
            }
        }
    }

    public function addNeracaSaldo(Request $request)
    {
        $id_lokasi = $request->id_lokasi;
        $tgl = $request->tgl;
        $id_akun = $request->id_akun;
        $debit_saldo = $request->debit_saldo;
        $kredit_saldo = $request->kredit_saldo;

        for ($i=0; $i < count($id_akun); $i++) { 
            $neracaSaldo = DB::table('tb_neraca_saldo')->where('id_akun', $id_akun[$i])->first();
            // dd($neracaSaldo);
            if($tgl == "") {

            } else {
                if(empty($neracaSaldo)) {
                    $data = [
                        'tgl' => $tgl,
                        'id_lokasi' => $id_lokasi,
                        'id_akun' => $id_akun[$i],
                        'debit_saldo' => $debit_saldo[$i],
                        'kredit_saldo' => $kredit_saldo[$i],
                    ];
                    DB::table('tb_neraca_saldo')->insert($data);
                } else {
                    $data = [
                        'tgl' => $tgl,
                        'id_lokasi' => $id_lokasi,
                        'id_akun' => $id_akun[$i],
                        'debit_saldo' => $debit_saldo[$i],
                        'kredit_saldo' => $kredit_saldo[$i],
                    ];
                    DB::table('tb_neraca_saldo')->where([['id_akun', $id_akun[$i]],['id_lokasi', $id_lokasi]])->update($data);
                }
            }

        }
        return redirect()->route('neracaSaldo', ['acc' => $id_lokasi])->with('sukses', 'Data berhasil Ditambah');
    }

    public function bukuBesar(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user', $id_user)
            ->where('id_menu', 32)->first();
        if (empty($id_menu)) {
            return back();
        } else {
            if (Auth::user()->jenis == 'adm') {
                $dari = $request->dari;
                $sampai = $request->sampai;

                if ($dari == '') {
                    $dari = date('Y-m-01');
                    $sampai = date('Y-m-d');
                } else {
                    $dari = $dari;
                    $sampai = $sampai;
                }
                $buku = DB::select("SELECT tb_akun.id_akun, tb_akun.no_akun, tb_akun.nm_akun, jurnal.debit, jurnal.kredit, neraca_saldo.debit_saldo, neraca_saldo.kredit_saldo
                    FROM tb_akun
                     LEFT JOIN (SELECT tb_jurnal.id_akun, SUM(tb_jurnal.debit) as debit, SUM(tb_jurnal.kredit) as kredit FROM tb_jurnal JOIN tb_akun ON tb_jurnal.id_akun = tb_akun.id_akun AND tb_jurnal.tgl between '$dari' AND '$sampai' AND tb_jurnal.id_lokasi = '$request->acc' AND tb_jurnal.id_buku != 6 GROUP BY tb_jurnal.id_akun) jurnal ON tb_akun.id_akun = jurnal.id_akun
                     
                     LEFT JOIN (SELECT tb_neraca_saldo.id_akun,sum(tb_neraca_saldo.debit_saldo) as debit_saldo, sum(tb_neraca_saldo.kredit_saldo) as kredit_saldo FROM tb_neraca_saldo WHERE tb_neraca_saldo.tgl between '$dari' AND  '$sampai' AND tb_neraca_saldo.id_lokasi = '$request->acc' GROUP BY tb_neraca_saldo.id_akun) neraca_saldo ON tb_akun.id_akun = neraca_saldo.id_akun
            
                     
                    
                     ORDER BY tb_akun.no_akun ASC");
                $tahun = DB::select("SELECT tgl FROM tb_jurnal GROUP BY YEAR('tgl')");
                $data = [
                    'title' => 'Buku Besar',
                    'logout' => $request->session()->get('logout'),
                    'buku' => $buku,
                    'tgl1' => $dari,
                    'tgl2' => $sampai,
                    'tahun' => $tahun
                ];
                return view('accounting.bukuBesar', $data);
            } else {
                return back();
            }
        }
    }

    public function detailBukuBesar(Request $request)
    {
        $id_lokasi = $request->acc;
        $id_akun = $request->id;
        $dari = $request->dari;
        $sampai = $request->sampai;

        $neracaSaldo = DB::selectOne("SELECT *
        FROM tb_neraca_saldo AS a
        WHERE a.id_akun = '$id_akun' AND a.tgl between '$dari' and '$sampai' and a.debit_saldo != '0' and a.kredit_saldo != '0' and a.id_lokasi = '$id_lokasi'");

        $buku = DB::select("SELECT * FROM tb_jurnal as a left join tb_post_center as c on a.id_post = c.id_post
        LEFT JOIN(SELECT tb_jurnal.id_akun, GROUP_CONCAT(DISTINCT tb_jurnal.ket SEPARATOR ', ') as ket2, 
        GROUP_CONCAT(DISTINCT b.nm_akun SEPARATOR ', ') as ket3, kd_gabungan 
        FROM tb_jurnal 
        LEFT JOIN tb_akun AS b ON b.id_akun = tb_jurnal.id_akun
        WHERE debit > 0 GROUP BY kd_gabungan) jurnal2 ON a.kd_gabungan = jurnal2.kd_gabungan and jurnal2.id_akun != a.id_akun
        where a.id_akun = '$id_akun' and a.tgl between '$dari' and '$sampai'
        order by a.tgl DESC");

        $data = [
            'title' => 'Detail Buku Besar',
            'buku' => $buku,
            'akun' => DB::table('tb_akun')->where('id_akun',$id_akun)->first(),
            'tgl1' => $dari,
            'tgl2' => $sampai,
            'id_akun' => $id_akun,
            'neraca' => $neracaSaldo
        ];

        return view('accounting.detailBukuBesar',$data);
    }

    public function printBukuBesar(Request $request)
    {
        $id_lokasi = $request->id_lokasi;
        if (empty($request->dari)) {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-d');
        } else {
            $tgl1 = $request->dari;
            $tgl2 = $request->sampai;
        }
        
        $buku = DB::select("SELECT tb_akun.id_akun, tb_akun.no_akun, tb_akun.nm_akun, jurnal.debit, jurnal.kredit, neraca_saldo.debit_saldo, neraca_saldo.kredit_saldo
                    FROM tb_akun
                     LEFT JOIN (SELECT tb_jurnal.id_akun, SUM(tb_jurnal.debit) as debit, SUM(tb_jurnal.kredit) as kredit FROM tb_jurnal JOIN tb_akun ON tb_jurnal.id_akun = tb_akun.id_akun AND tb_jurnal.tgl between '$tgl1' AND '$tgl2' AND tb_jurnal.id_lokasi = '$request->acc' AND tb_jurnal.id_buku != 6 GROUP BY tb_jurnal.id_akun) jurnal ON tb_akun.id_akun = jurnal.id_akun
                     
                     LEFT JOIN (SELECT tb_neraca_saldo.id_akun,sum(tb_neraca_saldo.debit_saldo) as debit_saldo, sum(tb_neraca_saldo.kredit_saldo) as kredit_saldo FROM tb_neraca_saldo WHERE tb_neraca_saldo.tgl between '$tgl1' AND  '$tgl2' AND tb_neraca_saldo.id_lokasi = '$request->acc' GROUP BY tb_neraca_saldo.id_akun) neraca_saldo ON tb_akun.id_akun = neraca_saldo.id_akun
            
                     
                    
                     ORDER BY tb_akun.no_akun ASC");
        $tahun = DB::select("SELECT tgl FROM tb_jurnal GROUP BY YEAR('tgl')");
        $bulan = DB::select("SELECT tgl FROM tb_jurnal GROUP BY MONTH('tgl')");
        $data = [
            'title' => 'Rekapitulasi Jurnal',
            'buku' => $buku,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ];

        return view('accounting.printBukuBesar', $data);
    }

    public function exportBukuBesar(Request $request)
    {
        $id_lokasi = $request->id_lokasi;
        if (empty($request->dari)) {
            $tgl1 = date('Y-m-01');
            $tgl2 = date('Y-m-d');
        } else {
            $tgl1 = $request->dari;
            $tgl2 = $request->sampai;
        }
        
        $buku = DB::select("SELECT tb_akun.id_akun, tb_akun.no_akun, tb_akun.nm_akun, jurnal.debit, jurnal.kredit, neraca_saldo.debit_saldo, neraca_saldo.kredit_saldo
                    FROM tb_akun
                     LEFT JOIN (SELECT tb_jurnal.id_akun, SUM(tb_jurnal.debit) as debit, SUM(tb_jurnal.kredit) as kredit FROM tb_jurnal JOIN tb_akun ON tb_jurnal.id_akun = tb_akun.id_akun AND tb_jurnal.tgl between '$tgl1' AND '$tgl2' AND tb_jurnal.id_lokasi = '$request->acc' AND tb_jurnal.id_buku != 6 GROUP BY tb_jurnal.id_akun) jurnal ON tb_akun.id_akun = jurnal.id_akun
                     
                     LEFT JOIN (SELECT tb_neraca_saldo.id_akun,sum(tb_neraca_saldo.debit_saldo) as debit_saldo, sum(tb_neraca_saldo.kredit_saldo) as kredit_saldo FROM tb_neraca_saldo WHERE tb_neraca_saldo.tgl between '$tgl1' AND  '$tgl2' AND tb_neraca_saldo.id_lokasi = '$request->acc' GROUP BY tb_neraca_saldo.id_akun) neraca_saldo ON tb_akun.id_akun = neraca_saldo.id_akun
            
                     
                    
                     ORDER BY tb_akun.no_akun ASC");
        $tahun = DB::select("SELECT tgl FROM tb_jurnal GROUP BY YEAR('tgl')");
        $bulan = DB::select("SELECT tgl FROM tb_jurnal GROUP BY MONTH('tgl')");
        
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setTitle('Jurnal Pengeluaran');
        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'D');
        $sheet->setCellValue('D1', 'M');
        $sheet->setCellValue('E1', 'Y');
        $sheet->setCellValue('F1', 'No Invoice');
        $sheet->setCellValue('G1', 'Keterangan');
        $sheet->setCellValue('H1', 'No Akun');
        $sheet->setCellValue('I1', 'Nama Akun');
        $sheet->setCellValue('J1', 'Debit');
        $sheet->setCellValue('K1', 'Kredit');


        $kolom = 2;
        $no = 1;
        $total_debit = 0;
        $total_kredit = 0;
        $total_saldo = 0;
        $laba_ditahan = 0;

        foreach ($buku as $b) {
            $saldo = $b->debit + $b->debit_saldo  - $b->kredit - $b->kredit_saldo;
            $debit = $b->debit + $b->debit_saldo;
            $kredit = $b->kredit + $b->kredit_saldo;
            $total_debit += $debit;
            $total_kredit += $kredit;
            $total_saldo += $saldo; 
            if ($debit == 0 and $kredit == 0) {
                continue;
            }
            $spreadsheet->setActiveSheetIndex(0);
            $sheet->setCellValue('A' . $kolom, $b->no_akun);
            $sheet->setCellValue('B' . $kolom, $b->nm_akun);
            $sheet->setCellValue('C' . $kolom, $debit);
            $sheet->setCellValue('D' . $kolom, $kredit);
            $sheet->setCellValue('E' . $kolom, $saldo);

            $kolom++;
        }
        $sheet->setCellValue('B' . $kolom, 'TOTAL');
        $sheet->setCellValue('C' . $kolom, $total_debit);
        $sheet->setCellValue('D' . $kolom, $total_kredit);
        $sheet->setCellValue('E' . $kolom, $total_saldo);

        $style = array(
            'font' => array(
                'size' => 9
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        $batas = $kolom - 1;
        $spreadsheet->getActiveSheet()->getStyle('A1:E' . $batas)->applyFromArray($style);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data Export Buku Besar.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
