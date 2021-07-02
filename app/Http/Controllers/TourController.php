<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class TourController extends Controller
{
    //tambah code ini di setiap controller view

    //end

    public function index(Request $request){
        $token = $request->session()->token();
        $token = csrf_token();
        $datatour= DB::table('travel_pack as tp')
        ->leftJoin('travel_img as ti',function($join){
            $join->on('tp.id','=','ti.travel_id');
            $join->on('ti.iscover','=',DB::raw('1'));
        })
        ->leftJoin('image_bank as ib',function($join){
            $join->on('ti.img_id','=','ib.id');
            $join->on('ti.iscover','=',DB::raw('1'));
        })
        ->select('tp.*','ib.file_nm')
        ->paginate(8);

        $data=array(
            'title'=>'Pengaturan Tour and Travel',
            'datarows'=>$datatour,
        );
        return view('pages/tourManage',$data);
    }
    public function getbookstravel(){
        $books=DB::table('travel_book as b')
        ->leftJoin('users as u',function($join){
            $join->on('b.member_id','=','u.google_id');
        })
        ->leftJoin('travel_pack as p','b.pack_id','=','p.id')
        ->where('b.pay_status','booked')
        ->select('b.*','u.name','u.email','u.phone_no','p.pack_nm','p.city')
        ->get();
        return response()->json($books);
    }
    public function newtravel(){
        $books=DB::table('travel_book as b')
        ->leftJoin('users as u',function($join){
            $join->on('b.member_id','=','u.google_id');
        })
        ->leftJoin('travel_pack as p','b.pack_id','=','p.id')
        ->where('b.pay_status','booked')
        ->select('b.*','u.name','u.email','u.phone_no','p.pack_nm','p.city')
        ->get();
        $data=array(
            'title'=>'New Booking Travel',
            'books'=>$books
        );

        return view('pages/newBookTravel',$data);
    }
    public function addnewtour(){
        $dataFacility= DB::table('facility')->where('fac_kind','Tour')
        ->get();
        $data=array(
            'title'=>'Tambah Tour Baru',
            'facilities'=>$dataFacility,
            'imagelist'=>array('','','',''),
            'isNew'=>1,
            'travel_id'=>null,
            'tourtimes'=>array()
        );
        return view('pages/tourPackMaintain', $data);
    }
    public function editTour(Request $request,$id){
        $dataFacility= DB::table('facility as f')
        ->leftJoin('travel_facility as tf',function($join) use ($id){
            $join->on('f.id','=','tf.fac_id');
            $join->on('tf.travel_id','=',DB::raw($id));
        })
        ->select('f.*', 'tf.note', 'tf.use_mk')
        ->where('f.fac_kind','Tour')
        ->get();

        $imagelist=DB::table('travel_img as ti')
        ->leftJoin('image_bank as ib','ti.img_id','=','ib.id')
        ->where('ti.travel_id',$id) ->orderBy('seq', 'asc')
        ->get();
        $isless=count($imagelist)<4?4-count($imagelist):0;
       // $arr=(array)$imagelist;
      //  print_r($arr);
        for($i=0;$i<$isless;$i++){
            $obj=new stdClass ();
            $obj->path=null;
            $obj->file_nm=null;
            $obj->note=null;
            $obj->iscover=0;
            $imagelist->push($obj);
        }
        $tourdata=DB::table('travel_pack')->where('id',$id)->first();
        $tourtime=DB::table('travel_time')->where('travel_id',$id)->get();

        $data=array(
            'title'=>'Ubah Tour',
            'facilities'=>$dataFacility,
            'isNew'=>0,
            'travel_id'=>$id,
            'datatour'=>$tourdata,
            'imagelist'=>$imagelist,
            'tourtimes'=>$tourtime
        );
        return view('pages/tourPackMaintain', $data);
    }

}
