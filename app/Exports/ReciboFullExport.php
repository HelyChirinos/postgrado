<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class ReciboFullExport implements FromView, ShouldAutoSize, WithTitle, WithColumnFormatting
{
    public $data;
    public function __construct($data =[])
    {
        $this->data = $data;
    }
    
    public function view(): View
    {
        return view('back.reportes.excel_full_recibos', $this->data);
    }

    public function columnFormats(): array
    {
        return 
        [
            'I' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'J' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'K' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'L' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'M' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'N' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

        ];
    }


    public function title(): string
    {
        return $this->data['periodo'];
    }
    
}
