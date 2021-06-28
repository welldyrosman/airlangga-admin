<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PicGalController extends Controller
{
    public function index(Request $request){
        $token = $request->session()->token();
        $token = csrf_token();
        $photos=DB::table('gallery')->get();
        $data=array(
            'title'=>'Gallery Photos',
            'photos'=>$photos
        );
        return view('pages/galleryPhotos',$data);
    }
    private $path='images/galleryphoto';
    public function deletepic(Request $request,$id){
        DB::beginTransaction();
        try{
            $team=DB::table('gallery')->where('id',$id)->first();

            if (Storage::disk('public')->exists($this->path."/".$team->photo)) {
                Storage::disk('public')->delete($this->path."/".$team->photo);
            }
            DB::table('gallery')->where('id',$id)->delete();
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
    public function updpic(Request $request,$id){
        DB::beginTransaction();
        try{
            $request->validate([
                'photonm' => 'required',
                'picseq' => 'required',
                ]
            );
            $n=$request->input('photonm');
            $f=$request->input('photodesc');
            $t=$request->input('picseq');
            DB::table('gallery')
            ->where('id',$id)
            ->update(array(
                "photo_nm"=>$n,
                "photo_desc"=>$f,
                "seq"=>$t,
                "upd_time"=>Carbon::now()
            ));
            if($request->hasFile('imgpic')){
                $file= $request->file('imgpic');
                $ext = $file->getClientOriginalExtension();
                $fileName =  'Gallery_'.$id.'_img.'.$ext;

                $imagesz = getimagesize($file);
                if($file->getSize()>500000){
                    throw new Exception("Ukuran Gambar Tidak Boleh Lebih dari 500Kb");
                }
                if (Storage::disk('public')->exists($this->path."/".$fileName)) {
                    Storage::disk('public')->delete($this->path."/".$fileName);
                }
                DB::table('gallery')->where('id',$id)->update(array(
                    "photo_path"=>$this->path,
                    "photo"=>$fileName
                ));
                $file->storeAs('public/'.$this->path, $fileName);
              //  throw new Exception("tets");
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        return Response()->json([
            "STATUS" => "OK"
        ], Response::HTTP_OK);
    }
    public function addnewpic(Request $request){


        DB::beginTransaction();
        try{
            $request->validate([
                'photonm' => 'required',
                'picseq' => 'required',
                ]
            );
            $n=$request->input('photonm');
            $f=$request->input('photodesc');
            $t=$request->input('picseq');
            $id=DB::table('gallery')->insertGetId(
                array(
                    "photo_nm"=>$n,
                    "photo_desc"=>$f,
                    "seq"=>$t,
                    "add_time"=>Carbon::now()
                )
            );
           // throw new Exception( $file= $request->file('imgpic'));
            if($request->hasFile('imgpic')){
                $file= $request->file('imgpic');
                    if($file->getSize()>500000){
                        throw new Exception("Ukuran Gambar Tidak Boleh Lebih dari 500Kb");
                    }
                    $ext = $file->getClientOriginalExtension();
                    $fileName =  'Gallery_'.$id.'_img.'.$ext;
                    DB::table('gallery')->where('id',$id)->update([
                        "photo_path"=>$this->path,
                        "photo"=>$fileName
                    ]);
                    $file->storeAs('public/'.$this->path, $fileName);
            }else{
                throw new Exception("Isi Fotonya gais");
            }
            DB::commit();
        }
        catch(Exception $e){
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        return Response()->json([
            "STATUS" => "OK"
        ], Response::HTTP_OK);
    }
}
