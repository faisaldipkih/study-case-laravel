<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Desa;
use App\Http\Resources\UserResource;

class DesaController extends Controller
{
    public function showKec(Request $request){
        $data = Desa::where('code_kec',$request->query('code_kec'))->get();
        return new UserResource(true, 'Data Desa!', $data);
    }
}
