<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use App\Models\PengajuanLembur;
use DataTables;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $pegawais = Pegawai::all();
            return DataTables::of($pegawais)
                ->addIndexColumn()
                ->editColumn('unit_kerja_id', function($row) {
                    return $row->unit_kerja->nama_unit;
                })
                ->editColumn('jabatan_id', function($row) {
                    return $row->jabatan->nama_jabatan;
                })
                ->editColumn('status_pegawai_id', function($row) {
                    return $row->status_pegawai->nama_status;
                })
                ->rawColumns([]) 
                ->make(true);
        }

        $total_pegawai = $this->total_pegawai();
        $total_pengajuan_cuti = $this->total_pengajuan_cuti();
        $total_pengajuan_lembur = $this->total_pengajuan_lembur();

        $perintah_lembur = $this->cek_perintah_lembur();
        $status_cuti = $this->cek_pengajuan_cuti();

        if(auth()->user()->is_admin == 1 || auth()->user()->is_admin == 2) 
        {
            return view('dashboard',compact(
                'total_pegawai',
                'total_pengajuan_cuti',
                'total_pengajuan_lembur',
                'perintah_lembur',
                'status_cuti'
            ));
        } else {
            
            if($status_cuti != null)
            {
                if($status_cuti->status_pengajuan == 1)
                {
                    $msg = 'Pengajuan cuti terakhir '.$status_cuti->tgl_mulai_cuti.' s.d '.$status_cuti->tgl_selesai_cuti.' disetujui.';
                } else {
                    $msg = 'Pengajuan cuti terakhir '.$status_cuti->tgl_mulai_cuti.' s.d '.$status_cuti->tgl_selesai_cuti.' ditolak.';
                }
            } else {
                $msg = 'Anda belum pernah melakukan cuti.';
            }

            return view('dashboard',compact(
                'total_pegawai',
                'total_pengajuan_cuti',
                'total_pengajuan_lembur',
                'perintah_lembur',
                'status_cuti',
                'msg'
            ));
        }
    }

    public function total_pegawai()
    {
        $count = Pegawai::count();
        return $count;
    }

    public function total_pengajuan_cuti()
    {
        $count = PengajuanCuti::count();
        return $count;
    }

    public function total_pengajuan_lembur()
    {
        $count = PengajuanLembur::count();
        return $count;
    }

    public static function cek_perintah_lembur()
    {
        $pegawai_id = Pegawai::where('user_id', auth()->user()->id)->first();
        if($pegawai_id == null) {
            return null;
        }
        $perintah_lembur = PengajuanLembur::join('pengajuan_lembur_details','pengajuan_lembur_details.pengajuan_lembur_id','pengajuan_lemburs.id')
        ->where('pegawai_id',$pegawai_id->id)
        ->where('is_finish', 0)
        ->orderBy('pengajuan_lembur_details.id', 'desc')
        ->first();

        return $perintah_lembur;
    }

    public static function cek_pengajuan_cuti()
    {
        $pegawai_id = Pegawai::where('user_id', auth()->user()->id)->first();
        if($pegawai_id == null) {
            return null;
        }
        $status_cuti = PengajuanCuti::where('pegawai_id', $pegawai_id->id)
        ->orderBy('id','desc')
        ->first();

        return $status_cuti;
    }
}
