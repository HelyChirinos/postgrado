<?php

use Illuminate\Support\Carbon;
use App\Models\Divisa;
use App\Models\Setup;
use Luecano\NumeroALetras\NumeroALetras;

if(!function_exists('formatMoney'))
{
    function formatMoney($number) {
        if (is_numeric($number)) {
            return number_format($number,2,",",".");
        } else {
            return '';
        }
    }
}

if(!function_exists('formatFecha'))
{
    function formatFecha($fecha) {
        return  Carbon::parse($fecha)->format('d-m-Y');
    }
}

if(!function_exists('toLetras'))
{
    function toLetras($monto) {

        $formatter = new NumeroALetras();
        $letras = ucfirst(strtolower($formatter->toInvoice($monto, 2,))).'Bolívares';

        return $letras;
    }
}


if(!function_exists('convertMoney'))
{
    function convertMoney($monto) {
        $monto = str_replace(',','.',str_replace('.','',trim($monto)));
        return $monto ;
    }
}

if(!function_exists('getSetup'))
{
    function getSetup() {
        $setup = Setup::first();
        
        return $setup;
    }
}


if(!function_exists('dolar_BCV'))
{
    // Depreciado
    function dolar_BCV () {

        $dolar_bcv = 1;
        $hoy = Carbon::now()->format("Y-m-d");
        $divisa = Divisa::whereDate('fecha',$hoy)->first();
        if (!$divisa) {
            $data = file_get_contents("https://bcv-api.deno.dev/v1/exchange");
            if ($data == false) {
                return $dolar_bcv;
            }            
            $cambio = json_decode($data,true);
            $dolar_bcv = $cambio['0']['exchange'];
            $dolar_fecha = $cambio['0']['date'];
            
            Divisa::create([
                'dolar'=> $dolar_bcv,
                'fecha' => $hoy,
                'divisa' => 'dolar',
            ]);
        } else {

            $dolar_bcv = $divisa->dolar;
        }

        return $dolar_bcv;
    }
}

if(!function_exists('cargar_divisa'))
{
    function cargar_divisa () {

        $dolar_bcv = 1;

        // FUENTE: pydolarve.org

        $data = file_get_contents("https://pydolarve.org/api/v1/dollar");
        $data = utfToIso($data);
        // POR AHORA VAMOS A DESCONCTAR COLOCANDOLO data=false
        $data=false;
        if ($data == false) {
            $divisa = Divisa::orderBy('fecha', 'DESC')->first();
            if ($divisa) {
                $dolar_bcv = max($divisa->dolar,$divisa->euro); 
 
            }            
            return $dolar_bcv;
        }            
        
        $cambio = json_decode($data);
      
        $dolar_bcv = $cambio->monitors->bcv->price;
        $fecha_bcv =$cambio->monitors->bcv->last_update;
        $hora_bcv = trim(substr($fecha_bcv,strpos($fecha_bcv,",")+1));
        $fecha_bcv = trim(substr($fecha_bcv,0,strpos($fecha_bcv,",")));
        $fecha = Carbon::createFromFormat('d/m/Y', $fecha_bcv,'America/Caracas')->toDate();
        $divisa = Divisa::whereDate('fecha',$fecha)->first();
        if (!$divisa) {
            Divisa::create([
                'divisa' => 'dolar',  
                'fecha' => $fecha,              
                'valor'=> $dolar_bcv,
            ]);
        } else {

            $dolar_bcv = $divisa->valor;
        }

        return $dolar_bcv;
    }
}


function iso8859_1_to_utf8(string $s): string {
    $s .= $s;
    $len = \strlen($s);

    for ($i = $len >> 1, $j = 0; $i < $len; ++$i, ++$j) {
        switch (true) {
            case $s[$i] < "\x80": $s[$j] = $s[$i]; break;
            case $s[$i] < "\xC0": $s[$j] = "\xC2"; $s[++$j] = $s[$i]; break;
            default: $s[$j] = "\xC3"; $s[++$j] = \chr(\ord($s[$i]) - 64); break;
        }
    }
    return substr($s, 0, $j);
}

function utfToIso(string $string): string {
    $s = (string) $string;
    $len = \strlen($s);
  
    for ($i = 0, $j = 0; $i < $len; ++$i, ++$j) {
        switch ($s[$i] & "\xF0") {
            case "\xC0":
            case "\xD0":
                $c = (\ord($s[$i] & "\x1F") << 6) | \ord($s[++$i] & "\x3F");
                $s[$j] = $c < 256 ? \chr($c) : '?';
                break;
  
            case "\xF0":
                ++$i;
                // no break
  
            case "\xE0":
                $s[$j] = '?';
                $i += 2;
                break;
  
            default:
                $s[$j] = $s[$i];
        }
    }
  
    return substr($s, 0, $j);
  }
  
  if(!function_exists('dolarDelDia'))
  {
    function dolarDelDia () {
        $dolar=null;
        $hoy=date("Y-m-d");
        $valor=Divisa::whereDate('fecha',$hoy)->first();
        if($valor){
            $dolar = max($valor->dolar,$valor->euro);
        }
        return $dolar;

    }
  }

  if(!function_exists('tasaDeFecha'))
  {
    function tasaDeFecha ($fecha) {

        $dolar=null;

        if ((!$fecha) || ($fecha=='')) {
            return $dolar;
        }
        $fecha = Carbon::parse($fecha)->format('Y-m-d');
        $valor= Divisa::whereDate('fecha', $fecha)->first();
        if($valor){
                $dolar = max($valor->dolar,$valor->euro);
        }
           
        return $dolar;

    }
  }


?>