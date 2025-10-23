@php
    $dolar = dolarDelDia ();
@endphp
<div class="row">
    <div class="col text-white text-end"><span style="font-size:19px;">Ref. :</span></div>
    <div class="col">
        @if ($dolar)
        <input type="numeric"  class="form-control text-center" value="{{$dolar. ' Bs.' }}" 
        style=" width: 80%; color:white; background:#6C757D; border-color:#212529; "  readonly>    
        @else
        <input type="numeric"  class="form-control text-center" value="{{' 0.00 Bs.' }}" 
        style=" width: 80%; color:white; background:#6C757D; border:2px solid #BB2D3B; "  readonly>                
        @endif
    </div>    
</div>    

