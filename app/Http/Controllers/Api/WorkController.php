<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Work;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class WorkController extends Controller
{
    public function index(){
        $data = Work::all();
        return new UserResource(true, 'Data Pekerjaan!', $data);
    }

    public function store(Request $request){
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Work::create([
            'name'=>$request->name,
        ]);

        //return response
        return new UserResource(true, 'Data Pekerjaan Berhasil Ditambahkan!', $post);
    }
}
