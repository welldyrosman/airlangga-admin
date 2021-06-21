<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index(){
        $data=array(
            'title'=>'Testimoni Control'
        );
        return view('pages/testimoni',$data);
    }
}
