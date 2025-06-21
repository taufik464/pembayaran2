<?php

namespace App\Exports;

use Rap2hpoutre\FastExcel\FastExcel;

trait ExportStyles
{
    public function applyStyles($sheet)
    {
        return function ($sheet) {
            // Header style
            $sheet->getStyle('A1:Z1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'color' => ['rgb' => '4CAF50']
                ]
            ]);

            // Auto size columns
            foreach (range('A', 'Z') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            // Number format
            $sheet->getStyle('E2:Z1000')->getNumberFormat()
                ->setFormatCode('#,##0.00;[Red]-#,##0.00');
        };
    }
}
