<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class TourController extends Controller
{
    //tambah code ini di setiap controller view
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(!session()->has('admin')) {
                return redirect('/');
            }
            return $next($request);
        });
    }
    //end

    public function index(Request $request){
        $token = $request->session()->token();
        $token = csrf_token();
        $datatour= DB::table('travel_pack')->paginate(2);

        $data=array(
            'title'=>'Pengaturan Tour and Travel',
            'datarows'=>$datatour,
        );
        return view('pages/tourManage',$data);
    }

    public function addnewtour(){
        $dataFacility= DB::table('facility')->where('fac_kind','Tour')
        ->get();
        $data=array(
            'title'=>'Tambah Tour Baru',
            'facilities'=>$dataFacility,
            'isNew'=>true
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
        ->where('ti.travel_id',$id)->get();
        $tourdata=DB::table('travel_pack')->where('id',$id)->first();
        $data=array(
            'title'=>'Ubah Tour',
            'facilities'=>$dataFacility,
            'isNew'=>false,
            'datatour'=>$tourdata,
            'imagelist'=>$imagelist
        );
        return view('pages/tourPackMaintain', $data);
    }

}
