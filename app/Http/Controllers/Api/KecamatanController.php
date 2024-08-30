<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class KecamatanController extends Controller
{
    public function index(){
        $data = Kecamatan::all();
        return new UserResource(true, 'Data Kecamatan!', $data);
    }

    public function store(Request $request){
        //define validation rules
        $validator = Validator::make($request->all(), [
            'code_kec'     => 'required',
            'code_kab'     => 'required',
            'name_kec'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Kecamatan::create([
            'code_kec'=>$request->code_kec,
            'code_kab'=>$request->code_kab,
            'name_kec'=>$request->name_kec
        ]);

        //return response
        return new UserResource(true, 'Data Kecamatan Berhasil Ditambahkan!', $post);
    }
}
