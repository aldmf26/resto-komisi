<?php

namespace App\Exports;

use App\Models\Gaji;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class GajiExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
 
    public function collection()
    {
        $lama = '2tahun';
        return Gaji::select('tb_karyawan.id_karyawan', 'tb_karyawan.nama', 'tb_posisi.nm_posisi', 'tb_karyawan.tgl_masuk', $lama, 'tb_gaji.rp_e', 'tb_gaji.rp_m', 'tb_gaji.rp_sp', 'tb_gaji.g_bulanan' )->join('tb_karyawan', 'tb_karyawan.id_karyawan', '=', 'tb_gaji.id_karyawan')->join('tb_posisi', 'tb_posisi.id_posisi', '=', 'tb_karyawan.id_posisi')->orderBy('tb_gaji.id_gaji', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID Karyawan',
            'Nama',
            'Posisi',
            'tanggal Masuk',
            'Lama',
            'Rp E',
            'Rp M',
            'Rp SP',
            'Bulanan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $style = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];
        $batas = Gaji::all();
        $batas = count($batas) + 1;
        return $sheet->getStyle('A1:I'.$batas)->applyFromArray($style);
    }
}
