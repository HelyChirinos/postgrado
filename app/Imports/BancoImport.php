<?php

namespace App\Imports;

use App\Models\Banco;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;

class BancoImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Banco([
            'fecha_operacion'=>($row['fechaoperacion']) ? Carbon::parse($row['fechaoperacion'])->format('Y-m-d'): null,
            'referencia'=>trim($row['referencia']),
            'descripcion'=>$row['descripcion'],
            'fecha_valor'=>($row['fechavalor']) ? Carbon::parse($row['fechavalor'])->format('Y-m-d'): null,
            'cargo'=>(float)str_replace(",",".",str_replace(",","",$row['cargo'])),            
            'abono'=>(float)str_replace(",",".",str_replace(",","",$row['abono'])),            
            'saldo'=>(float)str_replace(",",".",str_replace(",","",$row['saldo']))            
            //
        ]);
    }
}
