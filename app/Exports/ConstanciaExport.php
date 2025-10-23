<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;


class ConstanciaExport implements FromView, ShouldAutoSize, WithTitle, WithColumnFormatting, WithCustomStartCell
{

    public $data;
    public function __construct($data=[])
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('back.reportes.excel_constancias_mes', $this->data);
    }

    public function columnFormats(): array
    {
        return 
        [
            'B' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'C' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'D' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
           
        ];
    }

    public function title(): string
    {
        return 'constancias';
    }

    public function startCell(): string
    {
        return 'B2'; // This will make your data start from cell B2
    }

}
