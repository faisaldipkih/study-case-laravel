<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function store(Request $request){
        //define validation rules
        $validator = Validator::make($request->all(), [
            'role'     => 'required',
            'name'   => ['required', 'string', 'regex:/^[a-zA-Z\s]*$/','regex:/^(?!.*\b(Dr\.|Prof\.|Ir\.|H\.)\b)[a-zA-Z\s]*$/','regex:/^[a-zA-Z\s]+(?<!\b(S\.Kom|M\.Sc|Ph\.D)\b)$/'],
            'email' => 'required',
            'password' => ['required','string', 'confirmed', Password::min(8)
            ->mixedCase()
            ->letters()
            ->numbers()
            ->symbols()
            ->uncompromised()]
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = User::create([
            'email'=>$request->email,
            'name'=>$request->name,
            'role'=>$request->role,
            'password'=>Hash::make($request->password)
        ]);

        //return response
        return new UserResource(true, 'Data User Berhasil Ditambahkan!', $post);
    }
}
