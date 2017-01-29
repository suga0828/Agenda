<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Contact;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $objContact= new \App\Contact();
        $user=\Auth::user();
        $data=$user->contacts()->get()->all();
        return view('home')->with('contacts',$data);
    }
}
