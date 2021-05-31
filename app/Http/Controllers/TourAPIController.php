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
        DB::beginTransaction();
        try{
            $pack_nm=$request->input('pack_nm');
            $pack_time=$request->input('pack_time');
            $pack_price=$request->input('pack_price');
            $pack_city=$request->input('pack_city');
            $pack_desc=$request->input('pack_desc');
            $pack_vid=$request->input('pack_vid');
            $pack_fac=json_decode($request->input('listFac'));
            $pack_date=json_decode($request->input('listDate'));
            $iscover=null;
            if($request->has('iscover')){
                $iscover=$request->input('iscover');
            }
            if(!$iscover){
                throw new Exception("Mohon Pilih Cover Paket");
            }else{
                if(!$request->has('img_'.$iscover)){
                    throw new Exception("Mohon Pilih Gambar Cover");
                }
            }

            $arg=array(
                "pack_nm"=>$pack_nm,
                "city"=>$pack_city,
                "price"=>$pack_price,
                "pack_desc"=>$pack_desc,
                "add_time"=>Carbon::now(),
                "vid_url"=>$pack_vid
            );
            $idtour=DB::table('travel_pack')->insertGetId($arg);
            foreach($pack_date as $dates){
                DB::table('travel_time')->insert([
                    'travel_id'=>$idtour,
                    'travel_time'=>$dates
                ]);
            }
            foreach($pack_fac as $fac){
                DB::table('travel_facility')->insert([
                    'travel_id'=>$idtour,
                    'fac_id'=>$fac->id,
                    'note'=>$fac->note,
                    'use_mk'=> $fac->status
                    ]);
            }
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
                    $imagesz = getimagesize($file);
                    $path='images/370x300';
                    $imgdata=array(
                        'file_nm'=>$fileName,
                        'size'=>$imgsize,
                        'format'=>$ext,
                        'dimention'=>$imagesz[0].' x '.$imagesz[1],
                        'path'=>$path,
                        'use_mk'=>1,
                        'kind'=>'Product Photo'
                    );
                    $idimg=DB::table('image_bank')->insertGetId($imgdata);

                    $note="";
                    if($request->has('img_'.$i.'_note')){
                        $note=$request->has('img_'.$i.'_note');
                    }
                    DB::table('travel_img')->insert([
                        "travel_id"=>$idtour,
                        "img_id"=>$idimg,
                        "seq"=>$i,
                        "iscover"=>$i==$iscover?1:0,
                        "note"=>$note
                    ]);
                    $file->storeAs('public/'.$path, $fileName);
                }
            }
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            throw $e;
        }
        return Response()->json([
            "STATUS" => $pack_fac
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
