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
        $txt="";
        for($i=1;$i<5;$i++){
            if($request->hasFile('img_'.$i)) {
                $file      = $request->file('img_'.$i);
                $imagesz = getimagesize($file);
                if($file->getSize()>500000){
                    throw new Exception("Ukuran Gambar Tidak Boleh Lebih dari 500Kb");
                }
                if($imagesz[0]*1!=370 && $imagesz[1]*1!=300){
                    throw new Exception("Dimensi Gambar Harus 370 x 300 px");
                }
                $widthxheight = $imagesz[0].' x '.$imagesz[1];
                $txt.=','.$widthxheight.'['.$file->getSize().']';
            }
        }
        for($i=1;$i<5;$i++){
            if($request->hasFile('img_'.$i)) {
                $file      = $request->file('img_'.$i);
                $ext = $file->getClientOriginalExtension();
                $fileName =  '370x300'.time().'img'.$i.'.'.$ext;
                $imgsize=$file->getSize();
                $imgdata=array(
                    'file_nm'=>$fileName,
                );
                // DB::table('image_bank')->insert($imgdata);
                $file->storeAs('images/370x300', $fileName);
            }
        }
        $pack_nm=$request->input('pack_nm');
        $pack_time=$request->input('pack_time');
        $pack_price=$request->input('pack_price');
        $pack_city=$request->input('pack_city');
        $pack_desc=$request->input('pack_desc');
        $pack_vid=$request->input('pack_vid');
        $arg=array(
            "pack_nm"=>$pack_nm,
            "city"=>$pack_city,
            "price"=>$pack_price,
            "pack_desc"=>$pack_desc,
            "add_time"=>Carbon::now(),
            "vid_url"=>$pack_vid
        );
        //DB::table('travel_pack')->insert($arg);
        return Response()->json([
            "STATUS" =>  $txt
        ], Response::HTTP_OK);

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
