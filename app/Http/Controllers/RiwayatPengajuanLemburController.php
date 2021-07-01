<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PengajuanLembur;
use App\Models\PengajuanLemburDetail;
use App\Models\RiwayatPengajuanLembur;
use Illuminate\Http\Request;
use DataTables;

class RiwayatPengajuanLemburController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth()->user()->is_admin != 1)
        {            
            if ($request->ajax()) {
                $pegawai = Pegawai::where('user_id', auth()->user()->id)->first();
                $data = RiwayatPengajuanLembur::where('unit_kerja_id', $pegawai->unit_kerja_id)
                                                ->where('status_perubahan','selesai')
                                                ->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $button = '<a target="_blank" href="'.route('riwayat_lembur.print', $row->kode_pengajuan).'" name="view" id="'.$row->kode_pengajuan.'" class="view btn btn-info btn-sm"><i class="material-icons">print</i></a>';
                            return $button;
                        })
                        ->editColumn('unit_kerja_id', function($row) {
                            return $row->unit_kerja->nama_unit;
                        })
                        ->editColumn('jam_mulai_selesai', function($row) {
                            return $row->jam_mulai." s.d ".$row->jam_selesai;
                        })
                        ->rawColumns(['action','jam_mulai_selesai'])
                        ->make(true);
            }
    
            $perintah_lembur = HomeController::cek_perintah_lembur();
            return view('riwayat-lembur.pegawai.index', compact('perintah_lembur'));
        } else {
            if ($request->ajax()) {
                $data = RiwayatPengajuanLembur::all();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->editColumn('unit_kerja_id', function($row) {
                            return $row->unit_kerja->nama_unit;
                        })
                        ->editColumn('jam_mulai_selesai', function($row) {
                            return $row->jam_mulai." s.d ".$row->jam_selesai;
                        })
                        ->editColumn('status_perubahan', function($row) {
                            if($row->status_perubahan == 'proses')
                                return '<div class="badge badge-warning">proses '.$row->created_at.'</div>';
                            else
                                return '<div class="badge badge-success">selesai '.$row->created_at.'</div>';
                        })
                        ->rawColumns(['action','jam_mulai_selesai','status_perubahan'])
                        ->make(true);
            }
    
            return view('riwayat-lembur.index');
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
     * @param  \App\Models\RiwayatPengajuanLembur  $riwayatPengajuanLembur
     * @return \Illuminate\Http\Response
     */
    public function show(RiwayatPengajuanLembur $riwayatPengajuanLembur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RiwayatPengajuanLembur  $riwayatPengajuanLembur
     * @return \Illuminate\Http\Response
     */
    public function edit(RiwayatPengajuanLembur $riwayatPengajuanLembur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RiwayatPengajuanLembur  $riwayatPengajuanLembur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RiwayatPengajuanLembur $riwayatPengajuanLembur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RiwayatPengajuanLembur  $riwayatPengajuanLembur
     * @return \Illuminate\Http\Response
     */
    public function destroy(RiwayatPengajuanLembur $riwayatPengajuanLembur)
    {
        //
    }

    public function print($kode_pengajuan)
    {
        $pengajuan_lembur = PengajuanLembur::where('kode_pengajuan', $kode_pengajuan)->first();
        $hari = $this->hari(date('D', strtotime($pengajuan_lembur->tgl_pengajuan)));
        $tanggal = $this->tanggal($pengajuan_lembur->tgl_pengajuan);
        $pengajuan_lembur_detail = PengajuanLemburDetail::where('pengajuan_lembur_id', $pengajuan_lembur->id)->get();

        return view('riwayat-lembur.pegawai.print', compact(
            'pengajuan_lembur_detail',
            'pengajuan_lembur',
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
