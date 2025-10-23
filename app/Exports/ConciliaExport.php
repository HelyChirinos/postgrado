<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class ConciliaExport implements FromView, ShouldAutoSize, WithTitle, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public $data;
    public function __construct($data =[])
    {
        $this->data = $data;
    }
    
    public function view(): View
    {
        return view('back.bancos.excel_resumen', $this->data);
    }

    public function columnFormats(): array
    {
        return 
        [
            'B' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'C' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function title(): string
    {
        return 'conciliación';
    }
}
