<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function index(){
        $faqs=DB::table('faq')->get();
        $data=array(
            'title'=>'FAQ Control',
            'faqs'=>$faqs
        );
        return view('pages/faq',$data);
    }
    public function deletefaq(Request $request,$id){
        DB::beginTransaction();
        try{
            DB::table('faq')->where('id',$id)->delete();
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
    public function updfaq(Request $request,$id){
        $q=$request->input('question');
        $a=$request->input('answer');
        $s=$request->input('seq');
        DB::beginTransaction();
        try{
            DB::table('faq')
            ->where('id',$id)
            ->update(array(
                "subject"=>$q,
                "deskripsi"=>$a,
                "seq"=>$s
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
    public function newfaq(Request $request){
        $q=$request->input('question');
        $a=$request->input('answer');
        $s=$request->input('seq');
        DB::beginTransaction();
        try{
            DB::table('faq')->insert(
                array(
                    "subject"=>$q,
                    "deskripsi"=>$a,
                    "seq"=>$s
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
