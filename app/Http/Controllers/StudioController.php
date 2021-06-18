<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudioController extends Controller
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
    public function index(Request $request){
        $token = $request->session()->token();
        $token = csrf_token();
        $datatour= DB::table('studio_pack as tp')
        ->leftJoin('studio_img as ti',function($join){
            $join->on('tp.id','=','ti.travel_id');
            $join->on('ti.iscover','=',DB::raw('1'));
        })
        ->leftJoin('image_bank as ib',function($join){
            $join->on('ti.img_id','=','ib.id');
            $join->on('ti.iscover','=',DB::raw('1'));
        })
        ->select('tp.*','ib.file_nm')
        ->paginate(8);

        $data=array(
            'title'=>'Pengaturan Tour and Travel',
            'datarows'=>$datatour,
        );
        return view('pages/studioManage',$data);
    }
}
