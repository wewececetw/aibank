<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackEndController extends Controller
{
    
    public function index()
    {
        return view('Back_End.home.panel');
    }
    

}
