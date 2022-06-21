<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_menu = DB::table('tb_permission')->select('id_menu')->where('id_user',$id_user)
        ->where('id_menu', 6)->first();
        if(empty($id_menu)) {
            return back();
        } else {

            $data = [
                'title' => 'Discount',
                'logout' => $request->session()->get('logout'),
                'disc' => Discount::where('lokasi', $request->session()->get('id_lokasi'))->orderBy('id_discount', 'desc')->get(),
                'voucher' => Voucher::where('lokasi', $request->session()->get('id_lokasi'))->orderBy('id_voucher', 'desc')->get()
            ];
            return view("discount.discount",$data);
        }
    }

    public function addDiscount(Request $request)
    {

        $data = [
            'ket' => $request->ket,
            'jenis' => $request->jenis,
            'disc' => $request->disc,
            'dari' => $request->dari,
            'expired' => $request->expired,
            'status' => 1,
            'lokasi' => $request->session()->get('id_lokasi'),
        ];

        Discount::create($data);

        return redirect()->route('discount');
    }   


    public function deleteDiscount(Request $request)
    {
        Discount::where('id_discount', $request->id_discount)->delete();
        return redirect()->route('discount');
    }       

    public function in_discount(Request $request)
    {
        $data = [
            'status' => '1'
        ];
        
        Discount::where('id_discount', $request->id)->update($data);
    }
    public function un_discount(Request $request)
    {
        $data = [
            'status' => '0'
        ];
        Discount::where('id_discount', $request->id)->update($data);
    }

    public function addVoucher(Request $request)
    {
        $id_lokasi = $request->session()->get('id_lokasi');
        if($id_lokasi == 1) {
            $kode = 'TKMR' . strtoupper(random_int(1000000, 9999999));
        } else {
            $kode = 'SDB' . strtoupper(random_int(1000000, 9999999));
        }

        $data = [
            'kode' => $kode,
            'jumlah' => $request->jumlah,
            'ket' => $request->ket,
            'expired' => $request->expired,
            'status' => $request->status,
            'lokasi' => $id_lokasi,
            'terpakai' => 'belum',
            'admin' => Auth::user()->nama,
        ];

        Voucher::create($data);

        return redirect()->route('discount');

    }
    
    public function editVoucher(Request $request)
    {
        $data = [
            'jumlah' => $request->jumlah,
            'ket' => $request->ket,
            'expired' => $request->expired,
        ];

        Voucher::where('id_voucher', $request->id_voucher)->update($data);
        return redirect()->route('discount');
    }

    public function deleteVoucher(Request $request)
    {
        Voucher::where('id_voucher', $request->id_voucher)->delete();
        return redirect()->route('discount');
    }   

    public function in_voucher(Request $request)
    {
        $data = [
            'status' => '1'
        ];
        
        Voucher::where('id_voucher', $request->id)->update($data);
    }
    public function un_voucher(Request $request)
    {
        $data = [
            'status' => 0
        ];
        Voucher::where('id_voucher', $request->id)->update($data);
    }

    public function voucher_pembayaran(Request $request)
    {
        $kode = $request->kode;
        $id_lokasi = $request->session()->get('id_lokasi');
        $voucher = Voucher::where('lokasi', $id_lokasi)->where('kode', $kode)->first();
        

        if ($voucher) {
            if ($voucher->terpakai == 'terpakai' || $voucher->terpakai == 'sudah') {
                echo "terpakai";
            } if(date('Y-m-d') >= $voucher->expired) {
                echo 'expired';
            } else {
                if ($voucher->status == '0') {
                    echo "off";
                } else {
                    echo "$voucher->jumlah";
                }
            }
        } else {
            echo 'kosong';
        }
    }
    
    public function exportVoucher(Request $r)
    {
        $id_lokasi = $r->id_lokasi;
        $voucher = Voucher::where('lokasi', $id_lokasi)->orderBy('id_voucher', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1:D4')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        // lebar kolom
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(13);

        $sheet
            ->setCellValue('A1', 'Kode')
            ->setCellValue('B1', 'Jumlah')
            ->setCellValue('C1', 'Keterangan')
            ->setCellValue('D1', 'Expired')
            ->setCellValue('E1', 'STATUS');
        
            $kolom = 2;
            foreach ($voucher as $k) {
                $sheet
                    ->setCellValue('A'.$kolom,$k->kode)
                    ->setCellValue('B'.$kolom,$k->jumlah)
                    ->setCellValue('C'.$kolom,$k->ket)
                    ->setCellValue('D'.$kolom,$k->expired)
                    ->setCellValue('E'.$kolom,$k->terpakai);
                $kolom++;
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
            $batas = count($voucher) + 1;
            $sheet->getStyle('A1:E'.$batas)->applyFromArray($style);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Data Voucher.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
    }
    
}
