<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kabupaten;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class KabupatenController extends Controller
{
    public function index(){
        $data = Kabupaten::all();
        return new UserResource(true, 'Data Kabupaten!', $data);
    }

    public function store(Request $request){
        //define validation rules
        $validator = Validator::make($request->all(), [
            'code_prov'     => 'required',
            'code_kab'     => 'required',
            'name_kab'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Kabupaten::create([
            'code_kab'=>$request->code_kab,
            'code_prov'=>$request->code_prov,
            'name_kab'=>$request->name_kab
        ]);

        //return response
        return new UserResource(true, 'Data Kabupaten Berhasil Ditambahkan!', $post);
    }
}
