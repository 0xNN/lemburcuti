<?php

namespace App\Http\Controllers;

use App\Models\BankLegacy;
use App\Models\JenisCuti;
use App\Models\JenisCutiExtra;
use App\Models\MaksimumCuti;
use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use App\Models\PengajuanCutiDetail;
use App\Models\RencanaCuti;
use App\Models\RiwayatPengajuanCuti;
use Illuminate\Http\Request;
use DataTables;

class PengajuanCutiController extends Controller
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
            $pegawai = Pegawai::where('user_id', auth()->user()->id)->first();
            $bank_legacies = BankLegacy::all();
            $jenis_cutis = JenisCuti::all();

            if($pegawai->status_pegawai->id === 1)
            {
                $jenis_cuti_extras = JenisCutiExtra::all();
            } else {
                $jenis_cuti_extras = JenisCutiExtra::where('is_accepted', 1)->get();
            }

            $pengajuan_cuti = PengajuanCuti::where('pegawai_id', $pegawai->id)
                                            ->where('status_pengajuan', 0)
                                            ->orderBy('id', 'desc')
                                            ->first();

            $pegawai_pengganti = Pegawai::where('unit_kerja_id', $pegawai->unit_kerja_id)
                                        ->where('id','<>',$pegawai->id)
                                        ->get();

            $sisa_cuti = PengajuanCuti::where('pegawai_id', $pegawai->id)
                                        ->where('status_pengajuan', 1)
                                        ->orderBy('id', 'desc')
                                        ->first();

            $maksimum_cuti = MaksimumCuti::first();
            $rencana_cuti = RencanaCuti::all();

            $perintah_lembur = HomeController::cek_perintah_lembur();
            return view('pengajuan-cuti.pegawai.index', compact(
                'pegawai',
                'bank_legacies',
                'jenis_cutis',
                'jenis_cuti_extras',
                'pengajuan_cuti',
                'pegawai_pengganti',
                'maksimum_cuti',
                'sisa_cuti',
                'rencana_cuti',
                'perintah_lembur'
            ));
        } else {
            if ($request->ajax()) {
                $data = PengajuanCuti::where('status_pengajuan', 0)->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $button = '<div class="btn-group btn-group-sm" role="group">';
                            $button .= '<button type="button" name="setuju" id="setuju" data-id="'.$row->id.'" class="setuju btn btn-success btn-sm" value="setuju"><i class="material-icons">done</i></button>';
                            $button .= '<button type="button" name="tolak" id="tolak" data-id="'.$row->id.'" class="tolak btn btn-danger btn-sm" value="tolak"><i class="material-icons">close</i></button>';
                            $button .= '<a target="_blank" href="'.route('pengajuan_cuti.print', $row->id).'" name="view" id="'.$row->id.'" class="view btn btn-info btn-sm"><i class="material-icons">print</i></a>';
                            $button .= '</div>';    
                            return $button;
                        })
                        ->editColumn('unit_kerja_id', function($row) {
                            return $row->unit_kerja->nama_unit;
                        })
                        ->editColumn('pegawai_id', function($row) {
                            return $row->pegawai->nama_pegawai;
                        })
                        ->editColumn('jenis_cuti_id', function($row) {
                            return $row->jenis_cuti->nama_jenis;
                        })
                        ->editColumn('jenis_cuti_extra_id', function($row) {
                            return ($row->jenis_cuti_extra == null) ? '': $row->jenis_cuti_extra->nama_jenis_extra;
                        })
                        ->editColumn('bank_legacy_id', function($row) {
                            return $row->bank_legacy->nama_bank_legacy;
                        })
                        ->editColumn('status_pengajuan', function($row) {
                            return '<div class="badge badge-warning">diajukan</div>';
                        })
                        ->editColumn('pegawai_pengganti_id', function($row) {
                            $pegawai = PengajuanCutiDetail::where('pengajuan_cuti_id', $row->id)->get();
                            $alert = '';
                            foreach($pegawai as $data) {
                                $alert .= '<div class="badge badge-success">'.$data->pegawai->nama_pegawai.'</div>';
                            }
                            
                            return $alert;
                        })
                        ->rawColumns(['action','pegawai_pengganti_id','status_pengajuan'])
                        ->make(true);
            }

            return view('pengajuan-cuti.index');
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
        $pengajuan_cuti = PengajuanCuti::where('pegawai_id', $request->pegawai_id)->orderBy('id', 'desc')
                                        ->where('status_pengajuan', 1)
                                        ->first();
        if($pengajuan_cuti == null) {
            $maksimum_cuti = MaksimumCuti::first();
            
            $date_start = date_create($request->tgl_mulai_cuti);
            $date_end = date_create($request->tgl_selesai_cuti);
            $total_hari = date_diff($date_start, $date_end);

            if($total_hari->d > $maksimum_cuti->total_maksimum ) {
                return back()->with('failed', 'Total Cuti anda melebihi sisa cuti');
            }

//dd($request->jenis_cuti_extra_id);
            $post = PengajuanCuti::create([
                'kode_pengajuan'                    => 'PC-'.round(microtime(true) * 1000),
                'pegawai_id'                        => $request->pegawai_id,
                'unit_kerja_id'                     => $request->unit_kerja_id,
                'tgl_mulai_dinas'                   => $request->tgl_mulai_dinas,
                'bank_legacy_id'                    => $request->bank_legacy_id,
                'jenis_cuti_id'                     => $request->jenis_cuti_id,
                'rencana_cuti_id'                   => $request->rencana_cuti_id,
                'tgl_mulai_cuti'                    => $request->tgl_mulai_cuti,
                'tgl_selesai_cuti'                  => $request->tgl_selesai_cuti,
                'alamat_lengkap_selama_cuti'        => $request->alamat_lengkap_selama_cuti,
                'no_hp_selama_cuti'                 => $request->no_hp_selama_cuti,
                'keterangan'                        => $request->keterangan,
                'jenis_cuti_extra_id'               => ($request->jenis_cuti_extra_id == "0") ? null : $request->jenis_cuti_extra_id,
                'tgl_mulai_extra_cuti'              => ($request->tgl_mulai_extra_cuti == null) ? null: $request->tgl_mulai_extra_cuti,
                'alamat_lengkap_extra_selama_cuti'  => $request->alamat_lengkap_extra_selama_cuti,
                'no_hp_extra_selama_cuti'           => $request->no_hp_extra_selama_cuti,
                'keterangan_extra'                  => $request->keterangan_extra,
                'tgl_pengajuan'                     => $request->tgl_pengajuan,
                'total_hari'                        => $total_hari->d,
                'maksimum_cuti_id'                  => $maksimum_cuti->id,
                'sisa_cuti'                         => ($maksimum_cuti->total_maksimum - $total_hari->d),
                'user_id'                           => auth()->user()->id
            ]);

            foreach($request->pegawai_pengganti_id as $id) {
                PengajuanCutiDetail::create([
                    'pengajuan_cuti_id' => $post->id,
                    'pegawai_id' => $id,
                ]);
            }

            RiwayatPengajuanCuti::create([
                'kode_pengajuan' => $post->kode_pengajuan,
                'pegawai_id' => $post->pegawai_id,
                'unit_kerja_id' => $post->unit_kerja_id,
                'bank_legacy_id' => $post->bank_legacy_id,
                'jenis_cuti_id' => $post->jenis_cuti_id,
                'tgl_mulai_cuti' => $post->tgl_mulai_cuti,
                'tgl_selesai_cuti' => $post->tgl_selesai_cuti,
                'jenis_cuti_extra_id' => $post->jenis_cuti_extra_id,
                'tgl_pengajuan' => $post->tgl_pengajuan,
                'status_perubahan' => 'diajukan',
                'user_id' => $post->user_id,
                'user_modify' => auth()->user()->name,
            ]);

            return back()->with('success', 'Anda berhasil mengajukan cuti.');
        } else {
            $maksimum_cuti = MaksimumCuti::first();
            
            $date_start = date_create($request->tgl_mulai_cuti);
            $date_end = date_create($request->tgl_selesai_cuti);
            $total_hari = date_diff($date_start, $date_end);

            if($total_hari->d > $pengajuan_cuti->sisa_cuti ) {
                return back()->with('failed', 'Total Cuti anda melebihi sisa cuti');
            }

            $post = PengajuanCuti::create([
                'kode_pengajuan'                    => 'PC-'.round(microtime(true) * 1000),
                'pegawai_id'                        => $request->pegawai_id,
                'unit_kerja_id'                     => $request->unit_kerja_id,
                'tgl_mulai_dinas'                   => $request->tgl_mulai_dinas,
                'bank_legacy_id'                    => $request->bank_legacy_id,
                'jenis_cuti_id'                     => $request->jenis_cuti_id,
                'rencana_cuti_id'                   => $request->rencana_cuti_id,
                'tgl_mulai_cuti'                    => $request->tgl_mulai_cuti,
                'tgl_selesai_cuti'                  => $request->tgl_selesai_cuti,
                'alamat_lengkap_selama_cuti'        => $request->alamat_lengkap_selama_cuti,
                'no_hp_selama_cuti'                 => $request->no_hp_selama_cuti,
                'keterangan'                        => $request->keterangan,
                'jenis_cuti_extra_id'               => $request->jenis_cuti_extra_id,
                'tgl_mulai_extra_cuti'              => $request->tgl_mulai_extra_cuti,
                'alamat_lengkap_extra_selama_cuti'  => $request->alamat_lengkap_extra_selama_cuti,
                'no_hp_extra_selama_cuti'           => $request->no_hp_extra_selama_cuti,
                'keterangan_extra'                  => $request->keterangan_extra,
                'tgl_pengajuan'                     => $request->tgl_pengajuan,
                'total_hari'                        => $total_hari->d,
                'maksimum_cuti_id'                  => $maksimum_cuti->id,
                'sisa_cuti'                         => ($pengajuan_cuti->sisa_cuti - $total_hari->d),
                'user_id'                           => auth()->user()->id
            ]);

            foreach($request->pegawai_pengganti_id as $id) {
                PengajuanCutiDetail::create([
                    'pengajuan_cuti_id' => $post->id,
                    'pegawai_id' => $id,
                ]);
            }

            RiwayatPengajuanCuti::create([
                'kode_pengajuan' => $post->kode_pengajuan,
                'pegawai_id' => $post->pegawai_id,
                'unit_kerja_id' => $post->unit_kerja_id,
                'bank_legacy_id' => $post->bank_legacy_id,
                'jenis_cuti_id' => $post->jenis_cuti_id,
                'tgl_mulai_cuti' => $post->tgl_mulai_cuti,
                'tgl_selesai_cuti' => $post->tgl_selesai_cuti,
                'jenis_cuti_extra_id' => $post->jenis_cuti_extra_id,
                'tgl_pengajuan' => $post->tgl_pengajuan,
                'status_perubahan' => 'diajukan',
                'user_id' => $post->user_id,
                'user_modify' => auth()->user()->name,
            ]);

            return back()->with('success', 'Anda berhasil mengajukan cuti.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PengajuanCuti  $pengajuanCuti
     * @return \Illuminate\Http\Response
     */
    public function show(PengajuanCuti $pengajuanCuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PengajuanCuti  $pengajuanCuti
     * @return \Illuminate\Http\Response
     */
    public function edit(PengajuanCuti $pengajuanCuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PengajuanCuti  $pengajuanCuti
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->value == "setuju") {
            $pengajuan_cuti = PengajuanCuti::find($id);
            $pengajuan_cuti->status_pengajuan = 1;
            $pengajuan_cuti->save();

            RiwayatPengajuanCuti::create([
                'kode_pengajuan' => $pengajuan_cuti->kode_pengajuan,
                'pegawai_id' => $pengajuan_cuti->pegawai_id,
                'unit_kerja_id' => $pengajuan_cuti->unit_kerja_id,
                'bank_legacy_id' => $pengajuan_cuti->bank_legacy_id,
                'jenis_cuti_id' => $pengajuan_cuti->jenis_cuti_id,
                'tgl_mulai_cuti' => $pengajuan_cuti->tgl_mulai_cuti,
                'tgl_selesai_cuti' => $pengajuan_cuti->tgl_selesai_cuti,
                'jenis_cuti_extra_id' => $pengajuan_cuti->jenis_cuti_extra_id,
                'tgl_pengajuan' => $pengajuan_cuti->tgl_pengajuan,
                'status_perubahan' => 'setuju',
                'user_id' => $pengajuan_cuti->user_id,
                'user_modify' => auth()->user()->name,
            ]);

            return response()->json($pengajuan_cuti);
        } else {
            $pengajuan_cuti = PengajuanCuti::find($id);
            $pengajuan_cuti->status_pengajuan = 2;
            $pengajuan_cuti->alasan_tolak = $request->alasan_tolak;
            $pengajuan_cuti->save();

            RiwayatPengajuanCuti::create([
                'kode_pengajuan' => $pengajuan_cuti->kode_pengajuan,
                'pegawai_id' => $pengajuan_cuti->pegawai_id,
                'unit_kerja_id' => $pengajuan_cuti->unit_kerja_id,
                'bank_legacy_id' => $pengajuan_cuti->bank_legacy_id,
                'jenis_cuti_id' => $pengajuan_cuti->jenis_cuti_id,
                'tgl_mulai_cuti' => $pengajuan_cuti->tgl_mulai_cuti,
                'tgl_selesai_cuti' => $pengajuan_cuti->tgl_selesai_cuti,
                'jenis_cuti_extra_id' => $pengajuan_cuti->jenis_cuti_extra_id,
                'tgl_pengajuan' => $pengajuan_cuti->tgl_pengajuan,
                'status_perubahan' => 'tolak',
                'user_id' => $pengajuan_cuti->user_id,
                'user_modify' => auth()->user()->name,
            ]);

            return response()->json($pengajuan_cuti);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PengajuanCuti  $pengajuanCuti
     * @return \Illuminate\Http\Response
     */
    public function destroy(PengajuanCuti $pengajuanCuti)
    {
        //
    }

    public function print($id)
    {
        $pengajuan_cuti = PengajuanCuti::find($id);

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
