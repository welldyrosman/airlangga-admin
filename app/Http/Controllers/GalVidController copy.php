<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalVidController extends Controller
{
    public function index(){
        $data=array(
            'title'=>'Gallery Video'
        );
        return view('pages/faq',$data);
    }
}
