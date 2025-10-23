<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class GeneralExport implements FromView, ShouldAutoSize, WithTitle
{
    public $data;
    public $vista;
    public $titulo;

    public function __construct($vista, $data =[], $titulo='')
    {
        $this->vista = $vista;
        $this->data = $data;
        $this->titulo = $titulo;
  
    }
    
    public function view(): View
    {
        return view($this->vista, $this->data);
    }

    public function title(): string
    {
        return $this->titulo;
    }

}
