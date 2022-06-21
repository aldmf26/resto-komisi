<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KaryawanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Karyawan::select('id_karyawan', 'nama', 'nm_status', 'nm_posisi', 'tgl_masuk')->join('tb_status', 'tb_karyawan.id_status', '=', 'tb_status.id_status')->join('tb_posisi', 'tb_karyawan.id_posisi', '=', 'tb_posisi.id_posisi')->orderBy('id_karyawan', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID Karyawan',
            'Nama Karyawan',
            'Status',
            'Posisi',
            'tanggal Masuk'
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
        $batas = Karyawan::all();
        $batas = count($batas) + 1;
        return $sheet->getStyle('A1:E'.$batas)->applyFromArray($style);
    }
}
