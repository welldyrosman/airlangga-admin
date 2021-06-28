<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index(){
        $photos=DB::table('slide')->get();
        $data=array(
            'title'=>'Slide Photos',
            'slides'=>$photos
        );
        return view('pages/slide',$data);
    }
    private $path='images/slide';
    public function deleteslide(Request $request,$id){
        DB::beginTransaction();
        try{
            $team=DB::table('slide')->where('id',$id)->first();

            if (Storage::disk('public')->exists($this->path."/".$team->photo)) {
                Storage::disk('public')->delete($this->path."/".$team->photo);
            }
            DB::table('slide')->where('id',$id)->delete();
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
    public function disabledslide(Request $request,$id){
        DB::beginTransaction();
        try{
            $slide=DB::table('slide')->where('id',$id)->first();
            $updmk=$slide->stop_mk==false?true:false;
            DB::table('slide')->where('id',$id)->update(['stop_mk'=>$updmk]);
            DB::commit();
        }
        catch(Exception $e){
            DB::rollBack();
            throw new Exception("Update Failed");
        }
        return Response()->json([
            "STATUS" => "OK"
        ], Response::HTTP_OK);
    }
    public function updslide(Request $request,$id){
        DB::beginTransaction();
        try{
            $request->validate([
                'slidenm' => 'required',
                'slideseq' => 'required',
                ]
            );
            $n=$request->input('slidenm');
            $f=$request->input('slidedesc');
            $t=$request->input('slideseq');
            DB::table('slide')
            ->where('id',$id)
            ->update(array(
                "slide_nm"=>$n,
                "slide_desc"=>$f,
                "seq"=>$t,
                "upd_time"=>Carbon::now()
            ));
            if($request->hasFile('imgslide')){
                $file= $request->file('imgslide');
                $ext = $file->getClientOriginalExtension();
                $fileName =  'Slide'.$id.'_img.'.$ext;

                $imagesz = getimagesize($file);
                    if($file->getSize()>1000000){
                        throw new Exception("Ukuran Gambar Tidak Boleh Lebih dari 1Mb");
                    }
                    if($imagesz[0]*1!=1121 && $imagesz[1]*1!=301){
                        throw new Exception("Dimensi Gambar Harus 1120 x 300 px");
                    }
                    if (Storage::disk('public')->exists($this->path."/".$fileName)) {
                        Storage::disk('public')->delete($this->path."/".$fileName);
                    }
                    DB::table('slide')->where('id',$id)->update([
                        "photo_path"=>$this->path,
                        "photo"=>$fileName
                    ]);
                    $file->storeAs('public/'.$this->path, $fileName);
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            throw new Exception("Failed To Update".$e->getMessage());
        }
        return Response()->json([
            "STATUS" => "OK"
        ], Response::HTTP_OK);
    }
    public function addnewslide(Request $request){


        DB::beginTransaction();
        try{
            $request->validate([
                'slidenm' => 'required',
                'slideseq' => 'required',
                ]
            );
            $n=$request->input('slidenm');
            $f=$request->input('slidedesc');
            $t=$request->input('slideseq');
            $id=DB::table('slide')->insertGetId(
                array(
                    "slide_nm"=>$n,
                    "slide_desc"=>$f,
                    "seq"=>$t,
                    "add_time"=>Carbon::now()
                )
            );
            if($request->hasFile('imgslide')){
                $file= $request->file('imgslide');
                $imagesz = getimagesize($file);
                    if($file->getSize()>1000000){
                        throw new Exception("Ukuran Gambar Tidak Boleh Lebih dari 1MB");
                    }
                    if($imagesz[0]*1!=1121 && $imagesz[1]*1!=301){
                        throw new Exception("Dimensi Gambar Harus 1120 x 300 px");
                    }
                    $ext = $file->getClientOriginalExtension();
                    $fileName =  'Slide_'.$id.'_img.'.$ext;
                    DB::table('slide')->where('id',$id)->update([
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
