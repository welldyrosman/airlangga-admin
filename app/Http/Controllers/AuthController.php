<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index(Request $request){
        $token = $request->session()->token();
        $token = csrf_token();
        if(session()->has('admin')) {
            return view("index");
        }else{
            return view("login");
        }
    }
    public function login(Request $request){
        $token = $request->session()->token();
        $token = csrf_token();
        if(session()->has('admin')) {
            return view("index");
        }else{
            return view("login");
        }
    }
    public function loginservice(Request $request){
        $user_nm=$request->input('user_nm');
        $user_pass=$request->input('user_pass');
        $check=DB::table('admin')->where('userid',$user_nm)->first();
        if($check){
            $dbpass=Crypt::decryptString($check->password);
            if($user_pass!=$dbpass){
                return view('login');
            }
            $request->session()->put('admin',$check);
            return view("index");
        }else{
            return view('login');
        }
    }
    public function home(Request $request){
        if(session()->has('admin')) {
            return view("index");
        }else{
            return view("login");
        }
    }
    public function logout(Request $request){
        session()->forget('admin');
        return view("login");
    }
}
