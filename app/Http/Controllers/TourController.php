<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    //tambah code ini di setiap controller view
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(!session()->has('admin')) {
                return redirect('/');
            }
            return $next($request);
        });
    }
    //end

    public function index(){
        $datatour= DB::table('travel_pack')->paginate(2);
        $data=array(
            'title'=>'Pengaturan Tour and Travel',
            'datarows'=>$datatour
        );
        return view('pages/tourManage',$data);
    }

    public function addnewtour(){
        $data=array(
            'title'=>'Tambah Tour Baru'
        );
        return view('pages/tourPackMaintain', $data);
    }
}
