<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class TourAPIController extends Controller
{
    public function getpack(){
        return response()->json("adfads");
    }
    public function newpack(Request $request){
        $ret=new stdClass;
        $pack_nm=$request->input('pack_nm');
        $pack_time=$request->input('pack_time');
        $pack_price=$request->input('pack_price');
        $pack_city=$request->input('pack_city');
        $pack_desc=$request->input('pack_desc');
        $arg=array(
            "pack_nm"=>$pack_nm,
            "city"=>$pack_city,
            "price"=>$pack_price,
            "pack_desc"=>$pack_desc,
            "add_time"=>Carbon::now()
        );
        DB::table('travel_pack')->insert($arg);
        $ret->data=$arg;
        return response()->json($ret);
    }
    public function addfacility(Request $request){
        $fac_nm=$request->input('fac_nm');
        DB::table('facility')->insert([
            'fac_nm'=>$fac_nm,
            'fac_kind'=>'Tour',
            'use_mk'=>1,
            'add_time'=>Carbon::now()
        ]);
        return response()->json("Ok");
    }
}
