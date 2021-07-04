<?php

namespace App\Http\Controllers;

use App\Models\StatusPegawai;
use App\Models\Jabatan;
use App\Models\Jurusan;
use App\Models\Pegawai;
use App\Models\Pendidikan;
use App\Models\Penempatan;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pegawai::all();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $button = '<div class="btn-group btn-group-sm" role="group">';
                        $button .= '<button href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post"><i class="material-icons">mode_edit</i></button>';
                        $button .= '<button type="button" name="delete" id="'.$row->id.'" class="delete btn btn-danger btn-sm"><i class="material-icons">delete</i></button>';
                        $button .= '</div>';

                        if($row->user->is_admin == 1)
                        {
                            return 'Ini User Admin';
                        } else {
                            return $button;
                        }
                    })
                    ->editColumn('unit_kerja_id', function($row) {
                        return $row->unit_kerja->nama_unit;
                    })
                    ->editColumn('pendidikan_id', function($row) {
                        return $row->pendidikan->nama_pendidikan;
                    })
                    ->editColumn('jabatan_id', function($row) {
                        return $row->jabatan->nama_jabatan;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $pegawai = Pegawai::where('user_id', auth()->user()->id)->first();
        $unit_kerjas = UnitKerja::all();
        $pendidikans = Pendidikan::all();
        $jabatans = Jabatan::all();
        $jurusans = Jurusan::all();
        $penempatans = Penempatan::all();
        $users = User::whereNotIn('id', function($q) {
            $q->select('user_id')->from('pegawais');
        })->get();

        // dd($users);
        $status_pegawais = StatusPegawai::all();
        $perintah_lembur = HomeController::cek_perintah_lembur();
        return view('pegawai.index', compact(
            'unit_kerjas',
            'pendidikans',
            'jabatans',
            'jurusans',
            'penempatans',
            'users',
            'pegawai',
            'perintah_lembur',
            'status_pegawais'
        ));
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
        $id = $request->id;

        $pegawai = Pegawai::updateOrCreate(['id' => $id],[
            'nama_pegawai' => $request->nama_pegawai,
            'nip' => $request->nip,
            'nik' => $request->nik,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'unit_kerja_id' => $request->unit_kerja_id,
            'pendidikan_id' => $request->pendidikan_id,
            'jurusan_id' => $request->jurusan_id,
            'jabatan_id' => $request->jabatan_id,
            'penempatan_id' => $request->penempatan_id,
            'status_pegawai_id' => $request->status_pegawai_id,
            'user_id' => (auth()->user()->is_admin == 1) ? $request->user_id : auth()->user()->id,
        ]);

        return response()->json($pegawai);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('pegawais.id' => $id);
        $post  = Pegawai::join('users','users.id','pegawais.user_id')
                        ->where($where)->first();

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::updateOrCreate(['id' => $request->id,'user_id' => $id],[
            'nama_pegawai' => $request->nama_pegawai,
            'nip' => $request->nip,
            'nik' => $request->nik,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'unit_kerja_id' => $request->unit_kerja_id,
            'pendidikan_id' => $request->pendidikan_id,
            'jurusan_id' => $request->jurusan_id,
            'jabatan_id' => $request->jabatan_id,
            'penempatan_id' => $request->penempatan_id,
            'user_id' => auth()->user()->id,
        ]);

        return back()->with('success', 'Data berhasil di perbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Pegawai::where('id', $id)->delete();

        return response()->json($post);
    }

    public function populate_user()
    {
        $users = User::whereNotIn('id', function($q) {
            $q->select('user_id')->from('pegawais');
        })->get();

        return response()->json($users);
    }

    public function get_pegawai()
    {
        $pegawai = Pegawai::all();

        $arr = [];
        foreach($pegawai as $data) {
            $a['id'] = $data->id;
            $a['text'] = $data->nama_pegawai;
            array_push($arr, $a);
        }

        return response()->json([
            'results' => $arr
        ]);
    }

    public function get_pegawai_per_unit($id)
    {
        $pegawai = Pegawai::where('unit_kerja_id', $id)->get();

        $arr = [];
        foreach($pegawai as $data)
        {
            $a['id'] = $data->id;
            $a['text'] = $data->nama_pegawai;
            array_push($arr, $a);
        }

        return response()->json([
            'results' => $arr
        ]);
    }
}
