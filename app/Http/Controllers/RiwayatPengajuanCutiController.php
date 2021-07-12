<?php

namespace App\Http\Controllers;

use App\Models\PengajuanCuti;
use App\Models\PengajuanCutiDetail;
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
                        ->editColumn('action', function($row) {
                            if($row->status_perubahan == 'setuju')
                            {
                                $button = '<a target="_blank" href="'.route('riwayat_cuti.print', $row->kode_pengajuan).'" name="view" id="'.$row->kode_pengajuan.'" class="view btn btn-info btn-sm"><i class="material-icons">print</i></a>';

                                return $button;
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
                        ->rawColumns(['tgl_mulai_selesai_cuti','status_perubahan'])
                        ->make(true);
            }
    
            return view('riwayat-cuti.index-admin');
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

    public function print($kode_pengajuan)
    {
        $pengajuan_cuti = PengajuanCuti::where('kode_pengajuan', $kode_pengajuan)->first();

        $hari = $this->hari(date('D', strtotime($pengajuan_cuti->tgl_pengajuan)));
        $tanggal = $this->tanggal($pengajuan_cuti->tgl_pengajuan);
        $pengajuan_cuti_detail = PengajuanCutiDetail::where('pengajuan_cuti_id', $pengajuan_cuti->id)->get();

        return view('pengajuan-cuti.print', compact(
            'pengajuan_cuti_detail',
            'pengajuan_cuti',
            'tanggal',
            'hari'
        ));
    }

    public function tanggal($tanggal)
    {
        $bulan = array (1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }

    public function hari($day)
    {
        switch($day) {
            case 'Sun':
                return 'Minggu';
            case 'Mon':
                return 'Senin';
            case 'Tue':
                return 'Selasa';
            case 'Wed':
                return 'Rabu';
            case 'Thu':
                return 'Kamis';
            case 'Fri':
                return 'Jum\'at';
            case 'Sat':
                return 'Sabtu';
            default:
                return 'Not Found';
        }
    }
}
