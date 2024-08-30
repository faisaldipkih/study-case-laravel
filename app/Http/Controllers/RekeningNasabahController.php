<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekeningNasabah;
use App\Models\Work;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Mail;

class RekeningNasabahController extends Controller
{
    public function index(){
        return view('rekening');
    }

    public function getRekening(Request $request){
        if ($request->ajax()) {
            $data = RekeningNasabah::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '';
                    if(session('login_data')['role'] == 'supervisi' && !$row['status']){
                        $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" onclick="approve('.$row['id'].')">Approve</a>';
                    }
                    return $actionBtn;
                })
                ->addColumn('pekerjaan',function($row){
                    $work = Work::where('id',$row['works_id'])->first();
                    return $work['name'];
                })
                ->addColumn('status_pengajuan',function($row){
                    $status = 'Menunggu Approval';
                    if($row['status']){
                        $status = 'Disetujui';
                    }
                    return $status;
                })
                ->addColumn('nominal_rupiah',function($row){
                    $hasil_rupiah = "Rp " . number_format($row['nominal_setor'],2,',','.');
                    return $hasil_rupiah;
                })
                ->rawColumns(['action','pekerjaan','status_pengajuan','nominal_rupiah'])
                ->make(true);
        }
    }

    public function store(Request $request){
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_lengkap'   => 'required',
            'tempat_lahir'   => 'required',
            'tgl_lahir'   => 'required',
            'jenis_kelamin'   => 'required',
            'works_id'   => 'required',
            'alamat'   => 'required',
            'nominal_setor'   => 'required',
        ]);
        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = RekeningNasabah::create([
            "user_id"=>session('login_data')['id'],
            "works_id"=>$request->works_id,
            'nama_lengkap'=>$request->nama_lengkap,
            'tempat_lahir'=>$request->tempat_lahir,
            'tgl_lahir'=>$request->tgl_lahir,
            'jenis_kelamin'=>$request->jenis_kelamin,
            'alamat'=>$request->alamat,
            'nominal_setor'=>$request->nominal_setor,
        ]);

        //return response
        return new UserResource(true, 'Data Pengajuan Berhasil Ditambahkan!', $post);
    }

    public function approveRekening(Request $request){
        $data = RekeningNasabah::join('users','users.id','=','rekening_nasabahs.user_id')->where('rekening_nasabahs.id',$request->rekening_id)->first();
        $update = RekeningNasabah::where('id',$request->rekening_id)->update([
            "status"=>true
        ]);
        $passingDataToView = 'Approve Pengajuan Rekening';
        $data['title'] = 'Approve pengajuan rekening';

            Mail::send('mail.sendmail', ['passingDataToView'=> $passingDataToView,'nama_lengkap'=>$data['nama_lengkap']], function ($message) use ($data){
                $message->to($data["email"],$data['name']);
                $message->subject($data['title']);
            });
        return new UserResource(true, 'Data Pengajuan Berhasil Approve!', $update);
    }
}
