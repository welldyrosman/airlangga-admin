<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function showFormLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }
    public function login2(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string'
        ];

        $messages = [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
            'is_admin'  => true,
        ];

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('home');

        } else { // false

            //Login Fail
            Session::flash('error', 'Email atau password salah');
            return redirect()->route('login');
        }

    }
    public function showFormRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $rules = [
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed'
        ];

        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.min'              => 'Nama lengkap minimal 3 karakter',
            'name.max'              => 'Nama lengkap maksimal 35 karakter',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User();
        $user->name = ucwords(strtolower($request->name));
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $user->is_admin=true;
        $user->email_verified_at = \Carbon\Carbon::now();
        $simpan = $user->save();

        if($simpan){
            Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
            return redirect()->route('login');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('register');
        }
    }

    public function logout2()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('login');
    }

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
        if (Auth::check()) {
            return redirect('/home');
        }else{
            $ciphering = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;
            $encryption_iv = '1234567891011121';
            $encryption_key = "AdministratorKey";
            $encryption = openssl_encrypt("Airlangga@#123", $ciphering,
            $encryption_key, $options, $encryption_iv);
            return view("login",['title'=>"Login"]);
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
            Auth::login($check);
            //$request->session()->put('admin',$check);
            return redirect('/home');
        }else{
            return redirect('/');
        }
    }
    public function home(Request $request){
        return view("index");
    }
    public function logout(Request $request){
        session()->forget('admin');
        return redirect('/');
    }
}
