<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SigninController extends Controller
{
    public function index(){
        return view('signin');
    }

    public function signin(Request $request){
        $checkUser = User::where('email',$request->email)->first();
        $checkSignin = false;
        if ($checkUser != null) {
            if($checkUser['fail_login'] == 3){
                return json_encode([
                    "status" => false,
                    "message" => "Akun Diblokir"
                ]);
            }
            if (Hash::check($request['password'], $checkUser['password'])) {
                $checkSignin = true;
            }else{
                $checkUser['fail_login'] = $checkUser['fail_login'] + 1;
                User::where('id',$checkUser['id'])->update([
                    "fail_login"=>$checkUser['fail_login']
                ]);
            }
        }
        if ($checkSignin) {
            $dataLog = [
                "id" => $checkUser['id'],
                "name" => $checkUser['name'],
                "role" => $checkUser['role']
            ];

            Session::put(['is_login' => true, 'login_data' => $dataLog]);
            return json_encode([
                "status" => true,
                "message" => "Login Berhasil"
            ]);
        }
        return json_encode([
            "status" => false,
            "message" => "Login failed"
        ]);
    }

    public function logout(){
        session()->forget(['is_login','login_data']);
        return redirect('/');
    }
}
