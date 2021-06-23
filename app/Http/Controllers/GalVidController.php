<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class GalVidController extends Controller
{
    public function index(){
        $vid=DB::table('gallery_video')->get();
        $data=array(
            'title'=>'Gallery Video',
            'vidoes'=>$vid
        );
        return view('pages/galleryVideo',$data);
    }
    public function deletevid(Request $request,$id){
        DB::beginTransaction();
        try{
            DB::table('gallery_video')->where('id',$id)->delete();
            DB::commit();
        }
        catch(Exception $e){
            DB::rollBack();
            throw new Exception("Delete Failed");
        }
        return Response()->json([
            "STATUS" => "OK"
        ], Response::HTTP_OK);
    }
    public function updvid(Request $request,$id){
        $v=$request->input('vidname');
        $u=$request->input('url');
        $d=$request->input('viddesk');
        $s=$request->input('seq');
        DB::beginTransaction();
        try{
            DB::table('gallery_video')
            ->where('id',$id)
            ->update(array(
                "video_nm"=>$v,
                    "video_url"=>$u,
                    "video_desc"=>$d,
                    "use_mk"=>1,
                    "seq"=>$s,
                    "upd_time"=>Carbon::now()
            ));
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            throw new Exception("Failed To Update");
        }
        return Response()->json([
            "STATUS" => "OK"
        ], Response::HTTP_OK);
    }
    public function addnewvid(Request $request){
        $v=$request->input('vidname');
        $u=$request->input('url');
        $d=$request->input('viddesk');
        $s=$request->input('seq');
        DB::beginTransaction();
        try{
            DB::table('gallery_video')->insert(
                array(
                    "video_nm"=>$v,
                    "video_url"=>$u,
                    "video_desc"=>$d,
                    "use_mk"=>1,
                    "seq"=>$s,
                    "add_time"=>Carbon::now()
                )
            );
            DB::commit();
        }
        catch(Exception $e){
            DB::rollBack();
            throw new Exception("Failed To Save");
        }
        return Response()->json([
            "STATUS" => "OK"
        ], Response::HTTP_OK);
    }
}
