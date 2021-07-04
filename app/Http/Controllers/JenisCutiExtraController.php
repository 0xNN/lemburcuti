<?php

namespace App\Http\Controllers;

use App\Models\JenisCutiExtra;
use Illuminate\Http\Request;
use DataTables;

class JenisCutiExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JenisCutiExtra::all();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $button = '<div class="btn-group btn-group-sm" role="group">';
                        $button .= '<button href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post"><i class="material-icons">mode_edit</i></button>';
                        $button .= '<button type="button" name="delete" id="'.$row->id.'" class="delete btn btn-danger btn-sm"><i class="material-icons">delete</i></button>';
                        $button .= '</div>';

                        return $button;
                    })
                    ->editColumn('is_accepted', function($row) {
                        if($row->is_accepted == 0) {
                            return '<span class="badge badge-danger">Pegawai Tetap</span>';
                        } else {
                            return '<span class="badge badge-success">Pegawai Kontrak</span>';
                        }
                    })
                    ->rawColumns(['action','is_accepted'])
                    ->make(true);
        }
        return view('jenis-cuti-extra.index');
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

        $cek = $request->has('is_accepted') ? 1: 0;

        $post = JenisCutiExtra::updateOrCreate(['id' => $id],[
            'nama_jenis_extra' => $request->nama_jenis_extra,
            'is_accepted' => $cek,
        ]);

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisCutiExtra  $jenisCutiExtra
     * @return \Illuminate\Http\Response
     */
    public function show(JenisCutiExtra $jenisCutiExtra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisCutiExtra  $jenisCutiExtra
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = JenisCutiExtra::where($where)->first();

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JenisCutiExtra  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JenisCutiExtra $jabatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisCutiExtra  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = JenisCutiExtra::where('id', $id)->delete();

        return response()->json($post);
    }
}
