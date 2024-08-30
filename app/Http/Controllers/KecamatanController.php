<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Http\Resources\UserResource;

class KecamatanController extends Controller
{
    public function showKab(Request $request){
        $data = Kecamatan::where('code_kab',$request->query('code_kab'))->get();
        return new UserResource(true, 'Data Kecamatan!', $data);
    }
}
