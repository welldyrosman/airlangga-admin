<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        $data=array(
            'title'=>'Dashboard',
        );
        return view("pages/dashboard",$data);
    }
}
