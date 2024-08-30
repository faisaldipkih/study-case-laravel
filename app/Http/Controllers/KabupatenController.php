<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kabupaten;
use App\Http\Resources\UserResource;

class KabupatenController extends Controller
{
    public function showProv(Request $request){
        $data = Kabupaten::where('code_prov',$request->query('code_prov'))->get();
        return new UserResource(true, 'Data Kabupaten!', $data);
    }
}
