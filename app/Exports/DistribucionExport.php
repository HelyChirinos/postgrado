<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class DistribucionExport implements FromView, ShouldAutoSize, WithTitle 
{
    public $data;
    public function __construct($data =[])
    {
        $this->data = $data;
    }
    
    public function view(): View
    {
        return view('back.reportes.excel_distribucion', $this->data);
    }

    public function title(): string
    {
        return 'distrib.';
    }
}
