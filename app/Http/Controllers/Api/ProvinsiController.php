<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class ProvinsiController extends Controller
{
    public function index(){
        $data = Provinsi::all();
        return new UserResource(true, 'Data Provinsi!', $data);
    }

    public function store(Request $request){
        //define validation rules
        $validator = Validator::make($request->all(), [
            'code_prov'     => 'required',
            'name_prov'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Provinsi::create([
            'code_prov'=>$request->code_prov,
            'name_prov'=>$request->name_prov
        ]);

        //return response
        return new UserResource(true, 'Data Provinsi Berhasil Ditambahkan!', $post);
    }
}
