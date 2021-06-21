<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhyUsController extends Controller
{
    public function index(){
        $data=array(
            'title'=>'Why Us Setting'
        );
        return view('pages/whyus',$data);
    }
}
