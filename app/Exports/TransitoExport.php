<?php

namespace App\Exports;

use App\Models\Transito;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class TransitoExport implements FromView, ShouldAutoSize, WithTitle, WithColumnFormatting

{
 
    public $data;
    public function __construct($data =[])
    {
        $this->data = $data;
    }
    
    public function view(): View
    {
        return view('back.bancos.excel_transito', [
            'transito' => Transito::where('abono','>',0)->whereMonth('fecha_operacion', $this->data['mes'])
                ->whereYear('fecha_operacion', $this->data['ano'])->get(),
            'periodo' => $this->data['periodo'],
            'total' => Transito::where('abono','>',0)->whereMonth('fecha_operacion', $this->data['mes'])
                ->whereYear('fecha_operacion', $this->data['ano'])->sum('abono')
        ]);
    }

    public function columnFormats(): array
    {
        return 
        [
            'E' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Formato de número con separador de miles y decimales
        ];
    }

    public function title(): string
    {
        return 'transito';
    }

}
