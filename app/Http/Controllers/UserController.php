<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use DataTables;

class UserController extends Controller
{
    public function index(){
        return view('user');
    }

    public function getUser(Request $request){
        $data = User::latest()->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '';
                if($row['fail_login'] == 3){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" onclick="active('.$row['id'].')">Aktifkan</a>';
                }
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function active(Request $request){
        $update = User::where('id',$request->user_id)->update([
            "fail_login"=>0
        ]);
        return new UserResource(true, 'Data User Berhasil Diaktifkan!', $update);
    }
}
