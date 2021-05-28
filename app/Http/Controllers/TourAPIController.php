<?php

namespace App\Http\Controllers;

use Exception;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\Response;

class TourAPIController extends Controller
{
    public function getpack(){
        return response()->json("adfads");
    }
    public function newpack(Request $request){
        $ret=new stdClass;
        $fileName="XXX";
        if($request->hasFile('pack_cov')) {
            $fileName =  '370x300'.time().'.'.$request->pack_cov->extension();
            $request->pack_cov->storeAs('images/370x300', $fileName);
            return Response()->json([
                "image" => $fileName
            ], Response::HTTP_OK);

        }
        $ret->dd=$fileName;
        // if ($request->file('pack_cov')) {
        //     throw new Exception("EXIST");
        // }
        // throw new Exception("STOP");
        // $pack_nm=$request->input('pack_nm');
        // $pack_time=$request->input('pack_time');
        // $pack_price=$request->input('pack_price');
        // $pack_city=$request->input('pack_city');
        // $pack_desc=$request->input('pack_desc');
        // $pack_vid=$request->input('pack_vid');
        // $arg=array(
        //     "pack_nm"=>$pack_nm,
        //     "city"=>$pack_city,
        //     "price"=>$pack_price,
        //     "pack_desc"=>$pack_desc,
        //     "add_time"=>Carbon::now(),
        //     "vid_url"=>$pack_vid
        // );
        // DB::table('travel_pack')->insert($arg);
        // $ret->data=$arg;
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
