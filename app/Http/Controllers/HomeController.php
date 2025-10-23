<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    // Auth::logout();
        $dolar=dolarDelDia();   
        if (Auth::check()) {
            if (! session('APP')) {
                session(['APP.YEAR' => date('Y')]);
            }

            if (session('status')) {

                return redirect('/back/divisas')->with('status', session('status'));
                return view('back.home')->with('status', session('status'));
                
            }

            if(!$dolar){
                return redirect('/back/divisas')->with('alert', '!!! Divisas del día NO esta Actualizadas !!!');
            }
            return redirect('/back/divisas');
        } else {
            if (session('status')) {
                return view('front.home')->with('status', session('status'));
            }

            return view('front.home');
        }
    }
}
