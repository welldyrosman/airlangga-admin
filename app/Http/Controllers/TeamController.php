<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
     public function index(){
        $teams=DB::table('team')->get();
        $data=array(
            'title'=>'Team Setting',
            'teams'=>$teams
        );
        return view('pages/team',$data);
    }
    private $path='images/teams';
    public function deletetim(Request $request,$id){
        DB::beginTransaction();
        try{
            $team=DB::table('team')->where('id',$id)->first();

            if (Storage::disk('public')->exists($this->path."/".$team->photo)) {
                Storage::disk('public')->delete($this->path."/".$team->photo);
            }
            DB::table('team')->where('id',$id)->delete();
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
    public function updteam(Request $request,$id){
        DB::beginTransaction();
        try{
            $request->validate([
                'nicknm' => 'required',
                'fullnm' => 'required',
                'akunig' => 'required',
                'jabatan' => 'required',
                'timseq' => 'required',
                ]
            );
            $n=$request->input('nicknm');
            $f=$request->input('fullnm');
            $a=$request->input('akunig');
            $j=$request->input('jabatan');
            $t=$request->input('timseq');
            DB::table('team')
            ->where('id',$id)
            ->update(array(
                "nickname"=>$n,
                "fullname"=>$f,
                "ig"=>$a,
                "position"=>$j,
                "seq"=>$t,
                "upd_time"=>Carbon::now()
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
                    DB::table('team')->where('id',$id)->update([
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
    public function addnewteam(Request $request){


        DB::beginTransaction();
        try{
            $request->validate([
                'nicknm' => 'required',
                'fullnm' => 'required',
                'akunig' => 'required',
                'jabatan' => 'required',
                'timseq' => 'required',
                ]
            );
            $n=$request->input('nicknm');
            $f=$request->input('fullnm');
            $a=$request->input('akunig');
            $j=$request->input('jabatan');
            $t=$request->input('timseq');
            $id=DB::table('team')->insertGetId(
                array(
                    "nickname"=>$n,
                    "fullname"=>$f,
                    "ig"=>$a,
                    "position"=>$j,
                    "seq"=>$t,
                    "add_time"=>Carbon::now()
                )
            );
            if($request->hasFile('imgtim')){
                $file= $request->file('imgtim');
                $imagesz = getimagesize($file);
                    if($file->getSize()>500000){
                        throw new Exception("Ukuran Gambar Tidak Boleh Lebih dari 500Kb");
                    }
                    if($imagesz[0]*1>250 && $imagesz[1]*1>250){
                        throw new Exception("Dimensi Gambar maximal 250 x 250 px");
                    }
                    $ext = $file->getClientOriginalExtension();
                    $fileName =  'Team_ava_'.$id.'_img.'.$ext;
                    DB::table('team')->where('id',$id)->update([
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
