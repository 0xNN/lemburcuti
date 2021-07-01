<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PengajuanLembur;
use App\Models\PengajuanLemburDetail;
use App\Models\RiwayatPengajuanLembur;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use DataTables;
use PDF;

class PengajuanLemburController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth()->user()->is_admin == 1)
        {
            if ($request->ajax()) {
                $data = PengajuanLembur::all();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $button = '<div class="btn-group btn-group-sm" role="group">';
                            if($row->is_finish == 0) {
                                $button .= '<button type="button" name="delete" id="'.$row->id.'" class="delete btn btn-danger btn-sm"><i class="material-icons">delete</i></button>';
                            }
                            $button .= '<a target="_blank" href="'.route('pengajuan_lembur.print', $row->id).'" name="view" id="'.$row->id.'" class="view btn btn-info btn-sm"><i class="material-icons">print</i></a>';
                            $button .= '</div>';
    
                            return $button;
                        })
                        ->editColumn('unit_kerja_id', function($row) {
                            return $row->unit_kerja->nama_unit;
                        })
                        ->editColumn('is_finish', function($row) {
                            if($row->is_finish == 0) {
                                return '<a class="edit-status" id="edit-status" href="javascript:void(0)" data-toogle="tooltip" data-placement="top" data-id="'.$row->id.'" title="klik ini jika perintah lembur sudah dilaksanakan"><span class="badge badge-danger">proses</span></a>';
                            }
                            return '<div class="badge badge-success">selesai</div>';
                        })
                        ->rawColumns(['action','is_finish'])
                        ->make(true);
            }
    
            $unit_kerja = UnitKerja::all();
            $pegawai = Pegawai::all();
            return view('pengajuan-lembur.index', compact('unit_kerja','pegawai'));
        } else {
            $pegawai = Pegawai::where('user_id', auth()->user()->id)->first();

            $cek = PengajuanLembur::join('pengajuan_lembur_details','pengajuan_lembur_details.pengajuan_lembur_id','pengajuan_lemburs.id')
                                    ->where('pegawai_id', $pegawai->id)
                                    ->where('is_finish', 0)
                                    ->orderBy('pengajuan_lembur_details.id','desc')
                                    ->first();

            if($cek == null) {
                return view('pengajuan-lembur.pegawai.index', compact(
                    'pegawai',
                    'cek',
                ));
            }

            $pengajuan_lembur = PengajuanLembur::where('kode_pengajuan', $cek->kode_pengajuan)
                                                ->where('is_finish', $cek->is_finish)
                                                ->get();

            $pengajuan_lembur_detail = PengajuanLemburDetail::where('pengajuan_lembur_id', $pengajuan_lembur[0]->id)
                                        ->get();

            $perintah_lembur = HomeController::cek_perintah_lembur();
            return view('pengajuan-lembur.pegawai.index', compact(
                'pegawai',
                'cek',
                'pengajuan_lembur',
                'pengajuan_lembur_detail',
                'perintah_lembur'
            ));
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
        $kode_pengajuan = 'PL-'.round(microtime(true) * 1000);
        $tgl_pengajuan = date('Y-m-d');
        
        $pengajuan_lembur = PengajuanLembur::create([
            'kode_pengajuan' => $kode_pengajuan,
            'tgl_pengajuan' => $tgl_pengajuan,
            'unit_kerja_id' => $request->unit_kerja_id,
        ]);

        $pegawai = '';
        foreach($request->pegawai_id as $id)
        {
            $detail = PengajuanLemburDetail::create([
                'pengajuan_lembur_id' => $pengajuan_lembur->id,
                'pegawai_id' => $id,
                'jenis_pekerjaan' => $request->jenis_pekerjaan,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai
            ]);

            $pegawai .= $detail->pegawai->nama_pegawai.",";
        }

        RiwayatPengajuanLembur::create([
            'kode_pengajuan' => $pengajuan_lembur->kode_pengajuan,
            'tgl_pengajuan' => $pengajuan_lembur->tgl_pengajuan,
            'unit_kerja_id' => $pengajuan_lembur->unit_kerja_id,
            'jam_mulai' => $detail->jam_mulai,
            'jam_selesai' => $detail->jam_selesai,
            'pegawai' => $pegawai,
            'jenis_pekerjaan' => $detail->jenis_pekerjaan,
            'status_perubahan' => 'proses',
            'user_modify' => auth()->user()->name,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json($pengajuan_lembur);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PengajuanLembur  $pengajuanLembur
     * @return \Illuminate\Http\Response
     */
    public function show(PengajuanLembur $pengajuanLembur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PengajuanLembur  $pengajuanLembur
     * @return \Illuminate\Http\Response
     */
    public function edit(PengajuanLembur $pengajuanLembur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PengajuanLembur  $pengajuanLembur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->ajax())
        {
            if($request->text === "proses")
            {
                $pengajuan_lembur = PengajuanLembur::find($id);
                $pengajuan_lembur->is_finish = 1;
                $pengajuan_lembur->save();

                $detail = PengajuanLemburDetail::where('pengajuan_lembur_id', $pengajuan_lembur->id)->get();
                $pegawai = '';

                foreach($detail as $data)
                {
                    $pegawai .= $data->pegawai->nama_pegawai.",";
                }

                RiwayatPengajuanLembur::create([
                    'kode_pengajuan' => $pengajuan_lembur->kode_pengajuan,
                    'tgl_pengajuan' => $pengajuan_lembur->tgl_pengajuan,
                    'unit_kerja_id' => $pengajuan_lembur->unit_kerja_id,
                    'jam_mulai' => $detail[0]->jam_mulai,
                    'jam_selesai' => $detail[0]->jam_selesai,
                    'pegawai' => $pegawai,
                    'jenis_pekerjaan' => $detail[0]->jenis_pekerjaan,
                    'status_perubahan' => 'selesai',
                    'user_modify' => auth()->user()->name,
                    'user_id' => auth()->user()->id,
                ]);
                
                return response()->json($pengajuan_lembur);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PengajuanLembur  $pengajuanLembur
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengajuan_lembur = PengajuanLembur::whereId($id)->delete();
        $pengajuan_lembur_detail = PengajuanLemburDetail::where('pengajuan_lembur_id', $id)->delete();

        return response()->json([
            $pengajuan_lembur,
            $pengajuan_lembur_detail
        ]);
    }
    
    public function print($id)
    {
        $pengajuan_lembur = PengajuanLembur::find($id);

        $hari = $this->hari(date('D', strtotime($pengajuan_lembur->tgl_pengajuan)));
        $tanggal = $this->tanggal($pengajuan_lembur->tgl_pengajuan);
        $pengajuan_lembur_detail = PengajuanLemburDetail::where('pengajuan_lembur_id', $id)->get();

        return view('pengajuan-lembur.print', compact(
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
