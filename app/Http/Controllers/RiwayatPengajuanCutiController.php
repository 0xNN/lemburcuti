<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\RiwayatPengajuanCuti;
use Illuminate\Http\Request;
use DataTables;

class RiwayatPengajuanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth()->user()->is_admin != 1) {
            if ($request->ajax()) {
                $pegawai = Pegawai::where('user_id', auth()->user()->id)->first();
                $data = RiwayatPengajuanCuti::where('pegawai_id', $pegawai->id)->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->editColumn('unit_kerja_id', function($row) {
                            return $row->unit_kerja->nama_unit;
                        })
                        ->editColumn('pegawai_id', function($row) {
                            return $row->pegawai->nama_pegawai;
                        })
                        ->editColumn('jenis_cuti_id', function($row) {
                            return $row->jenis_cuti->nama_jenis;
                        })
                        ->editColumn('bank_legacy_id', function($row) {
                            return $row->bank_legacy->nama_bank_legacy;
                        })
                        ->editColumn('tgl_mulai_selesai_cuti', function($row) {
                            return $row->tgl_mulai_cuti." s.d ".$row->tgl_selesai_cuti;
                        })
                        ->editColumn('status_perubahan', function($row) {
                            if($row->status_perubahan == 'diajukan') {
                                return '<div class="badge badge-warning">diajukan</div>';
                            } else if($row->status_perubahan == 'tolak') {
                                return '<div class="badge badge-danger">tolak</div>';
                            } else {
                                return '<div class="badge badge-success">setuju</div>';
                            }
    
                        })
                        ->rawColumns(['action','tgl_mulai_selesai_cuti','status_perubahan'])
                        ->make(true);
            }
    
            $perintah_lembur = HomeController::cek_perintah_lembur();
            return view('riwayat-cuti.index', compact('perintah_lembur'));
        } else {
            if ($request->ajax()) {
                $data = RiwayatPengajuanCuti::all();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->editColumn('unit_kerja_id', function($row) {
                            return $row->unit_kerja->nama_unit;
                        })
                        ->editColumn('pegawai_id', function($row) {
                            return $row->pegawai->nama_pegawai;
                        })
                        ->editColumn('jenis_cuti_id', function($row) {
                            return $row->jenis_cuti->nama_jenis;
                        })
                        ->editColumn('bank_legacy_id', function($row) {
                            return $row->bank_legacy->nama_bank_legacy;
                        })
                        ->editColumn('tgl_mulai_selesai_cuti', function($row) {
                            return $row->tgl_mulai_cuti." s.d ".$row->tgl_selesai_cuti;
                        })
                        ->editColumn('status_perubahan', function($row) {
                            if($row->status_perubahan == 'diajukan') {
                                return '<div class="badge badge-warning">diajukan</div>';
                            } else if($row->status_perubahan == 'tolak') {
                                return '<div class="badge badge-danger">tolak</div>';
                            } else {
                                return '<div class="badge badge-success">setuju</div>';
                            }
    
                        })
                        ->rawColumns(['action','tgl_mulai_selesai_cuti','status_perubahan'])
                        ->make(true);
            }
    
            return view('riwayat-cuti.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RiwayatPengajuanCuti  $riwayatPengajuanCuti
     * @return \Illuminate\Http\Response
     */
    public function show(RiwayatPengajuanCuti $riwayatPengajuanCuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RiwayatPengajuanCuti  $riwayatPengajuanCuti
     * @return \Illuminate\Http\Response
     */
    public function edit(RiwayatPengajuanCuti $riwayatPengajuanCuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RiwayatPengajuanCuti  $riwayatPengajuanCuti
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RiwayatPengajuanCuti $riwayatPengajuanCuti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RiwayatPengajuanCuti  $riwayatPengajuanCuti
     * @return \Illuminate\Http\Response
     */
    public function destroy(RiwayatPengajuanCuti $riwayatPengajuanCuti)
    {
        //
    }
}
