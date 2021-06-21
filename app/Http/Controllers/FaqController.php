<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(){
        $data=array(
            'title'=>'FAQ Control'
        );
        return view('pages/faq',$data);
    }
}
