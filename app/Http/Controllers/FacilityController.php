<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(){
        $data=array(
            'title'=>'Tambah Tour Baru'
        );
        return view('pages/masterFacility',$data);
    }
}
