<?php

namespace App\Http\Controllers;

use App\Models\JenisCuti;
use App\Models\PengajuanCuti;
use App\Models\PengajuanLembur;
use App\Models\PengajuanLemburDetail;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        $unit_kerja = UnitKerja::all();
        $jenis_cuti = JenisCuti::all();
        return view('laporan.index', compact(
            'unit_kerja',
            'jenis_cuti'
        ));
    }

    public function print_cuti($jenis_cuti = null, $tgl_pengajuan = null)
    {
        if($tgl_pengajuan != null && $jenis_cuti != null) {            
            $pengajuan_cuti = PengajuanCuti::where('jenis_cuti_id', $jenis_cuti)
                                            ->where('tgl_pengajuan', $tgl_pengajuan)
                                            ->get();
        } else if($tgl_pengajuan == null && $jenis_cuti != null) {
            $pengajuan_cuti = PengajuanCuti::where('jenis_cuti_id', $jenis_cuti)
                                            ->get();
        } else if($tgl_pengajuan != null && $jenis_cuti == null) {
            $pengajuan_cuti = PengajuanCuti::where('tgl_pengajuan', $tgl_pengajuan)
                                            ->get();
        } else {
            $pengajuan_cuti = PengajuanCuti::all();
        }

        $pdf = PDF::loadView('laporan.print-cuti', compact('pengajuan_cuti'))->setPaper('a4', 'landscape');
        $path = public_path('pdf/');
        $filename = time().'.'.'pdf';
        $pdf->save($path.'/'.$filename);

        $pdf = public_path('pdf/'.$filename);
        return response()->make(file_get_contents($pdf), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }

    public function print_lembur($unit_kerja_id = null, $tgl_pengajuan = null)
    {
        if($tgl_pengajuan != null && $unit_kerja_id != null) {            
            $pengajuan_lembur = PengajuanLembur::where('unit_kerja_id', $unit_kerja_id)
                                            ->where('tgl_pengajuan', $tgl_pengajuan)
                                            ->get();
        } else if($tgl_pengajuan == null && $unit_kerja_id != null) {
            $pengajuan_lembur = PengajuanLembur::where('unit_kerja_id', $unit_kerja_id)
                                            ->get();
        } else if($tgl_pengajuan != null && $unit_kerja_id == null) {
            $pengajuan_lembur = PengajuanLembur::where('tgl_pengajuan', $tgl_pengajuan)
                                            ->get();
        } else {
            $pengajuan_lembur = PengajuanLembur::all();
        }

        $detail = PengajuanLemburDetail::all();

        $pdf = PDF::loadView('laporan.print-lembur', compact('pengajuan_lembur','detail'))->setPaper('a4', 'landscape');
        $path = public_path('pdf/');
        $filename = time().'.'.'pdf';
        $pdf->save($path.'/'.$filename);

        $pdf = public_path('pdf/'.$filename);
        return response()->download($pdf);
    }
}
