<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

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

    public function index(Request $request){
        $token = $request->session()->token();
        $token = csrf_token();
        $datatour= DB::table('travel_pack')->paginate(2);

        $data=array(
            'title'=>'Pengaturan Tour and Travel',
            'datarows'=>$datatour,
        );
        return view('pages/tourManage',$data);
    }

    public function addnewtour(){
        $dataFacility= DB::table('facility')->where('fac_kind','Tour')->get();
        $data=array(
            'title'=>'Tambah Tour Baru',
            'facilities'=>$dataFacility
        );
        return view('pages/tourPackMaintain', $data);
    }

}
