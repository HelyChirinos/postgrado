@extends('layouts.back')

@section('content')
    <div class="row mb-2">
        <div class="col-xxl-6">
            @if(session('locale')=='es')
                @include('back.components.home-links-es')
            @else
                @include('back.components.home-links')
            @endif    
        </div>

        <div class="col-xxl-6">
            @if(session('locale')=='es')
                @include('back.components.home-stats-es')
            @else
                @include('back.components.home-stats')
            @endif            
        </div>
    </div>
@endsection
