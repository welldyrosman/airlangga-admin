<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(!session()->has('admin')) {
                return redirect('/');
            }
            return $next($request);
        });
    }
    public function index(){
        $datatour= DB::table('travel_pack')->paginate(2);
        $data=array(
            'title'=>'Pengaturan Tour and Travel',
            'datarows'=>$datatour
        );
        return view('pages/tourManage',$data);
    }
}
