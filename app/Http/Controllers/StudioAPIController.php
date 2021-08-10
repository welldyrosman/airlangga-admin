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
use Alert;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class StudioAPIController extends Controller
{
    public function getpack(){
        return response()->json("adfads");
    }
    public function addfacility(Request $request){
        $fac_nm=$request->input('fac_nm');
        DB::table('facility')->insert([
            'fac_nm'=>$fac_nm,
            'fac_kind'=>'Studio',
            'use_mk'=>1,
            'add_time'=>Carbon::now()
        ]);
        return response()->json("Ok");
    }
    function addtstudiofacility($data,$id){
        foreach($data as $fac){
            DB::table('studio_facility')->insert([
                'studio_id'=>$id,
                'fac_id'=>$fac->id,
                'note'=>$fac->note,
                'use_mk'=> $fac->status
                ]);
        }
    }

    function checkingimage($request){
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
            }
        }
    }
    private $path='images/370x300';
    function insertImage($request,$id,$iscover,$i){
        $file      = $request->file('img_'.$i);
        $ext = $file->getClientOriginalExtension();
        $fileName =  '370x300_'.$id.'_img'.$i.'.'.$ext;
        $imgsize=$file->getSize();
        $imagesz = getimagesize($file);
        $imgdata=array(
            'file_nm'=>$fileName,
            'size'=>$imgsize,
            'format'=>$ext,
            'dimention'=>$imagesz[0].' x '.$imagesz[1],
            'path'=>$this->path,
            'use_mk'=>1,
            'kind'=>'Product Photo'
        );
        $idimg=DB::table('image_bank')->insertGetId($imgdata);

        $note="";
        if($request->has('img_'.$i.'_note')){
            $note=$request->input('img_'.$i.'_note');
        }
        DB::table('studio_img')->insert([
            "studio_id"=>$id,
            "img_id"=>$idimg,
            "seq"=>$i,
            "iscover"=>$i==$iscover?1:0,
            "note"=>$note
        ]);
        $file->storeAs('public/'.$this->path, $fileName);

    }
    function checkcover($request,$isnew){
        $iscover=null;
        if($request->has('iscover')){
            $iscover=$request->input('iscover');
        }
        if(!$iscover){
            throw new Exception("Mohon Pilih Cover Paket");
        }else{
            if(!$request->has('img_'.$iscover)&&$isnew){
                throw new Exception("Mohon Pilih Gambar Cover");
            }
            if(!$isnew){
                $iscover=$request->input('iscover');
            }
        }
        return $iscover;
    }
    public function newpack(Request $request){
        $ret=new stdClass;
        $validated = $request->validate([
            'pack_nm' => 'required|max:45',
            'pack_price' => 'required',
            'type' => 'required',
            'pack_desc' => 'required',
        ]);

        $txt="";
        DB::beginTransaction();
        try{
            $pack_nm=$request->input('pack_nm');
            $pack_price=$request->input('pack_price');
            $type=$request->input('type');
            $pack_desc=$request->input('pack_desc');
            $pack_fac=json_decode($request->input('listFac'));
            $iscover=$this->checkcover($request,true);
            $arg=array(
                "pack_nm"=>$pack_nm,
                "type"=>$type,
                "price"=>$pack_price,
                "pack_desc"=>$pack_desc,
                "add_time"=>Carbon::now(),
            );


            $idstu=DB::table('studio_pack')->insertGetId($arg);

            $this->addtstudiofacility($pack_fac,$idstu);
            $this->checkingimage($request);
            for($i=1;$i<5;$i++){
                if($request->hasFile('img_'.$i)) {
                    $this->insertImage($request,$idstu,$iscover,$i);
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
    public function updpack(Request $request,$id){
        $validated = $request->validate([
            'pack_nm' => 'required|max:45',
             'pack_price' => 'required',
             'type' => 'required',
             'pack_desc' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $pack_nm=$request->input('pack_nm');
            $pack_price=$request->input('pack_price');
            $pack_city=$request->input('pack_city');
            $pack_desc=$request->input('pack_desc');
            $pack_vid=$request->input('pack_vid');
            $pack_fac=json_decode($request->input('listFac'));
            $type=$request->input('type');
            $arg=array(
                "pack_nm"=>$pack_nm,
                "price"=>$pack_price,
                "pack_desc"=>$pack_desc,
                "type"=>$type,
                "upd_time"=>Carbon::now(),
            );
            $iscover=$this->checkcover($request,false);
            for($i=1;$i<5;$i++){
                $imgsrc=DB::table('studio_img')->where('seq',$i)->where('studio_id',$id)->first();
                if($request->hasFile('img_'.$i)) {
                    if($imgsrc){
                        $imgbnk=DB::table('image_bank')->where('id',$imgsrc->img_id)->first();
                        if (Storage::disk('public')->exists($imgbnk->file_nm)) {
                            Storage::disk('public')->delete($this->path."/".$imgbnk->file_nm);
                        }
                        DB::table('image_bank')->where('id',$imgsrc->img_id)->delete();
                        DB::table('studio_img')
                        ->where('img_id',$imgsrc->img_id)
                        ->where('studio_id',$imgsrc->studio_id)->delete();
                    }
                    $this->insertImage($request,$id,$iscover,$i);
                }else{
                    if($imgsrc){
                        DB::table('studio_img')->where('seq',$i)->where('studio_id',$id)->update(
                            array('note'=>$request->input('img_'.$i.'_note'))
                        );
                    }
                }
            }
            DB::table('studio_img')->where('studio_id',$id)->update(['iscover'=>0]);
            DB::table('studio_img')->where('studio_id',$id)->where('seq',$iscover)->update(['iscover'=>1]);
            DB::table('studio_facility')->where('studio_id',$id)->delete();
            $this->addtstudiofacility($pack_fac,$id);
            DB::table('studio_pack')->where('id',$id)->update($arg);
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
        return response()->json(['id'=>$id,'data'=> $arg,'facility'=>$pack_fac], Response::HTTP_OK);
    }
    public function delpack(Request $request,$id){
        DB::beginTransaction();
        try{
            $imagelist=DB::table('studio_img')->where('studio_id',$id)->get();
            foreach($imagelist as $image){
                $imgsrc=DB::table('image_bank')->where('id',$image->img_id)->first();
                if (Storage::disk('public')->exists($imgsrc->file_nm)) {
                    Storage::disk('public')->delete($this->path."/".$imgsrc->file_nm);
                }

                DB::table('image_bank')->where('id',$imgsrc->id)->delete();
            }
            DB::table('studio_img')->where('studio_id',$id)->delete();
            DB::table('studio_facility')->where('studio_id',$id)->delete();
            DB::table('studio_pack')->where('id',$id)->delete();
            DB::commit();
        }
        catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
        return response()->json(['STATUS'=>'OK'],Response::HTTP_OK);
    }
    public function disabledpack(Request $request,$id){
        DB::beginTransaction();
        try{
            $pack=DB::table('studio_pack')->where('id',$id)->first();
            $status=$pack->use_mk?0:1;
            DB::table('studio_pack')->where('id',$id)->update(["use_mk"=>$status]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
        return response()->json(['STATUS'=>'OK'],Response::HTTP_OK);
    }
}
