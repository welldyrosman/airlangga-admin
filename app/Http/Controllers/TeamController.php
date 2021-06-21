<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
     public function index(){
        $data=array(
            'title'=>'Team Setting'
        );
        return view('pages/team',$data);
    }
}
