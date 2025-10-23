<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteFullExport implements WithMultipleSheets
{
  use Exportable;
  public $data;
  public function __construct($data =[])
  {
      $this->data = $data;
  }

  public function sheets(): array
  {
      $sheets = [];
      // Agregas las hojas
      array_push($sheets, new ReciboFullExport($this->data));
      array_push($sheets, new DistribucionExport($this->data));
      array_push($sheets, new ConciliaExport($this->data));
      array_push($sheets, new TransitoExport($this->data));
 
      return $sheets;
  }
  
}
