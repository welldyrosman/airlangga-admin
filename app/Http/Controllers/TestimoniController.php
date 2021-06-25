<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index(){
        $testimonies=DB::table('testimoni')->get();
        $data=array(
            'title'=>'Testimoni Control',
            'testimonies'=>$testimonies
        );
        return view('pages/testimoni',$data);
    }
    private $path='images/testi';
    public function deletetesti(Request $request,$id){
        DB::beginTransaction();
        try{
            $team=DB::table('testimoni')->where('id',$id)->first();

            if (Storage::disk('public')->exists($this->path."/".$team->photo)) {
                Storage::disk('public')->delete($this->path."/".$team->photo);
            }
            DB::table('testimoni')->where('id',$id)->delete();
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
    public function updtesti(Request $request,$id){
        DB::beginTransaction();
        try{
            $request->validate([
                'fullnm' => 'required',
                'testimoni' => 'required',
                'testiseq' => 'required',
                ]
            );
            $f=$request->input('fullnm');
            $t=$request->input('testimoni');
            $s=$request->input('testiseq');
            DB::table('testimoni')
            ->where('id',$id)
            ->update(array(
                "people_name"=>$f,
                "testimoni"=>$t,
                "seq"=>$s,
                "add_time"=>Carbon::now()
            ));
            if($request->hasFile('imgtim')){
                $file= $request->file('imgtim');
                $ext = $file->getClientOriginalExtension();
                $fileName =  'Team_ava_'.$id.'_img.'.$ext;

                $imagesz = getimagesize($file);
                    if($file->getSize()>500000){
                        throw new Exception("Ukuran Gambar Tidak Boleh Lebih dari 500Kb");
                    }
                    if($imagesz[0]*1>250 && $imagesz[1]*1>250){
                        throw new Exception("Dimensi Gambar maximal 250 x 250 px");
                    }
                    if (Storage::disk('public')->exists($this->path."/".$fileName)) {
                        Storage::disk('public')->delete($this->path."/".$fileName);
                    }
                    DB::table('testimoni')->where('id',$id)->update([
                        "photo_path"=>$this->path,
                        "photo"=>$fileName
                    ]);
                    $file->storeAs('public/'.$this->path, $fileName);
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            throw new Exception("Failed To Update");
        }
        return Response()->json([
            "STATUS" => "OK"
        ], Response::HTTP_OK);
    }
    public function addnewtesti(Request $request){
       // DB::beginTransaction();
        DB::connection('mysql')->beginTransaction();
        try{
            $request->validate([
                'fullnm' => 'required',
                'testimoni' => 'required',
                'testiseq' => 'required',
                ]
            );
            $f=$request->input('fullnm');
            $t=$request->input('testimoni');
            $s=$request->input('testiseq');
            $id=DB::table('testimoni')->insertGetId(
                array(
                    "people_name"=>$f,
                    "testimoni"=>$t,
                    "seq"=>$s,
                    "add_time"=>Carbon::now()
                )
            );
            if($request->hasFile('imgtesti')){
                $file= $request->file('imgtesti');
                $imagesz = getimagesize($file);
                    if($file->getSize()>500000){
                        throw new Exception("Ukuran Gambar Tidak Boleh Lebih dari 500Kb");
                    }
                    if($imagesz[0]*1>250 && $imagesz[1]*1>250){
                        throw new Exception("Dimensi Gambar maximal 250 x 250 px");
                    }
                    $ext = $file->getClientOriginalExtension();
                    $fileName =  'Testi_ava_'.$id.'_img.'.$ext;
                    DB::table('testimoni')->where('id',$id)->update([
                        "photo_path"=>$this->path,
                        "photo"=>$fileName
                    ]);
                    $file->storeAs('public/'.$this->path, $fileName);
                    DB::connection('mysql')->commit();
            }else{
                DB::connection('mysql')->rollBack();
                throw new Exception("Isi Fotonya gais");
            }
        }
        catch(Exception $e){
            DB::connection('mysql')->rollBack();
            throw new Exception($e->getMessage());
        }

        return Response()->json([
            "STATUS" => "OK"
        ], Response::HTTP_OK);
    }
}
