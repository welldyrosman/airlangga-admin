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
            return redirect('/home');
        }else{
            return redirect('/');
        }
    }
    public function login(Request $request){
        $token = $request->session()->token();
        $token = csrf_token();
        if(session()->has('admin')) {
            return redirect('/home');
        }else{
            $ciphering = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;
            $encryption_iv = '1234567891011121';
            $encryption_key = "AdministratorKey";
            $encryption = openssl_encrypt("Airlangga@#123", $ciphering,
            $encryption_key, $options, $encryption_iv);


            return view("login",['title'=>$encryption]);
        }
    }
    public function loginservice(Request $request){
        $user_nm=$request->input('user_nm');
        $user_pass=$request->input('user_pass');
        $check=DB::table('admin')->where('userid',$user_nm)->first();
        if($check){
            $ciphering = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $decryption_iv = '1234567891011121';
            $options = 0;
            $decryption_key = "AdministratorKey";
            $dbpass=openssl_decrypt ($check->password, $ciphering,
            $decryption_key, $options, $decryption_iv);
            if($user_pass!=$dbpass){
                return view('login');
            }
            $request->session()->put('admin',$check);
            return redirect('/home');
        }else{
            return redirect('/');
        }
    }
    public function home(Request $request){
        if(session()->has('admin')) {

            return view("index");
        }else{
            return redirect('/');
        }
    }
    public function logout(Request $request){
        session()->forget('admin');
        return redirect('/');
    }
}
