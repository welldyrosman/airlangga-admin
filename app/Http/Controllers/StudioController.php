<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class StudioController extends Controller
{

    public function addnewstudio(Request $request){
            $dataFacility= DB::table('facility')->where('fac_kind','Studio')
            ->get();
            $data=array(
                'title'=>'Tambah Paket Baru',
                'facilities'=>$dataFacility,
                'imagelist'=>array('','','',''),
                'isNew'=>1,
                'travel_id'=>null,
                'tourtimes'=>array()
            );
            return view('pages/studioPackMaintain', $data);

    }
    public function index(Request $request){
        $token = $request->session()->token();
        $token = csrf_token();
        $datatour= DB::table('studio_pack as tp')
        ->leftJoin('studio_img as ti',function($join){
            $join->on('tp.id','=','ti.studio_id');
            $join->on('ti.iscover','=',DB::raw('1'));
        })
        ->leftJoin('image_bank as ib',function($join){
            $join->on('ti.img_id','=','ib.id');
            $join->on('ti.iscover','=',DB::raw('1'));
        })
        ->select('tp.*','ib.file_nm')
        ->paginate(8);

        $data=array(
            'title'=>'Pengaturan Studio',
            'datarows'=>$datatour,
        );
        return view('pages/studioManage',$data);
    }
    public function editstudio(Request $request,$id){
        $dataFacility= DB::table('facility as f')
        ->leftJoin('studio_facility as tf',function($join) use ($id){
            $join->on('f.id','=','tf.fac_id');
            $join->on('tf.studio_id','=',DB::raw($id));
        })
        ->select('f.*', 'tf.note', 'tf.use_mk')
        ->where('f.fac_kind','Studio')
        ->get();

        $imagelist=DB::table('studio_img as ti')
        ->leftJoin('image_bank as ib','ti.img_id','=','ib.id')
        ->where('ti.studio_id',$id) ->orderBy('seq', 'asc')
        ->get();
        $isless=count($imagelist)<4?4-count($imagelist):0;
       // $arr=(array)$imagelist;
      //  print_r($arr);
        for($i=0;$i<$isless;$i++){
            $obj=new stdClass();
            $obj->path=null;
            $obj->file_nm=null;
            $obj->note=null;
            $obj->iscover=0;
            $imagelist->push($obj);
        }
        $tourdata=DB::table('studio_pack')->where('id',$id)->first();
        //$tourtime=DB::table('studio_time')->where('studio_id',$id)->get();

        $data=array(
            'title'=>'Ubah Paket Studio',
            'facilities'=>$dataFacility,
            'isNew'=>0,
            'travel_id'=>$id,
            'datatour'=>$tourdata,
            'imagelist'=>$imagelist,
           // 'tourtimes'=>$tourtime
        );
        return view('pages/studioPackMaintain', $data);
    }
}
