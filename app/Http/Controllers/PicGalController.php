<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PicGalController extends Controller
{
    public function index(){
        $data=array(
            'title'=>'Gallery Photos'
        );
        return view('pages/galleryPhotos',$data);
    }
}
