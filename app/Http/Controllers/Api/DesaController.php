<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Desa;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class DesaController extends Controller
{
    public function index(){
        $data = Desa::all();
        return new UserResource(true, 'Data Desa!', $data);
    }

    public function store(Request $request){
        //define validation rules
        $validator = Validator::make($request->all(), [
            'code_kec'     => 'required',
            'code_desa'     => 'required',
            'name_desa'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Desa::create([
            'code_kec'=>$request->code_kec,
            'code_desa'=>$request->code_desa,
            'name_desa'=>$request->name_desa
        ]);

        //return response
        return new UserResource(true, 'Data Desa Berhasil Ditambahkan!', $post);
    }
}
