<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use DataTables;
class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Jabatan::all();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $button = '<div class="btn-group btn-group-sm" role="group">';
                        $button .= '<button href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post"><i class="material-icons">mode_edit</i></button>';
                        $button .= '<button type="button" name="delete" id="'.$row->id.'" class="delete btn btn-danger btn-sm"><i class="material-icons">delete</i></button>';
                        $button .= '</div>';

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('jabatan.index');
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

        $post = Jabatan::updateOrCreate(['id' => $id],[
            'nama_jabatan' => $request->nama_jabatan,
        ]);

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Jabatan::where($where)->first();

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Jabatan::where('id', $id)->delete();

        return response()->json($post);
    }
}
