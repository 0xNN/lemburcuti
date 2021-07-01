<?php

namespace App\Http\Controllers;

use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pendidikan::all();
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

        return view('pendidikan.index');
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

        $post = Pendidikan::updateOrCreate(['id' => $id],[
            'nama_pendidikan' => $request->nama_pendidikan,
        ]);

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function show(Pendidikan $pendidikan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Pendidikan::where($where)->first();

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pendidikan $pendidikan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pendidikan  $pendidikan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Pendidikan::where('id', $id)->delete();

        return response()->json($post);
    }
}
