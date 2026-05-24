<?php

namespace App\Exports;

use App\Models\Reserva;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\Number;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\Php;

class ReservasExport implements 
    FromCollection, 
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithColumnFormatting,
    WithEvents

{
    public function collection()
    {
        return Reserva::with('user')->get()->map(function ($r) {
            return [
                $r->user->cedula ?? '',
                $r->user->nombre ?? '',
                $r->user->email ?? '',
                $r->user->telefono ?? '',
                $r->vehiculo_id,
                $r->fecha_inicio,
                $r->fecha_fin,
                (float) $r->precio_total,
                ucfirst($r->estado)
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Cédula',
            'Nombre',
            'Email',
            'Teléfono',
            'Vehículo',
            'Fecha Inicio',
            'Fecha Fin',
            'Total',
            'Estado'
        ];
    }

    public function styles(Worksheet $sheet)
    {

        return [

            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'argb' => 'FFD700' // amarillo
                    ],
                ],
            ],

        ];

    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

            $event->sheet->getStyle('H2:H1000')
                ->getNumberFormat()
                ->setFormatCode('"$"#,##0');

            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => '"$"#,##',
            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'G' => NumberFormat::FORMAT_DATE_YYYYMMDD
        ];
    }

}

