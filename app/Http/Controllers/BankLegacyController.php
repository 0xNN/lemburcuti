<?php

namespace App\Http\Controllers;

use App\Models\BankLegacy;
use Illuminate\Http\Request;
use DataTables;

class BankLegacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BankLegacy::all();
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
        return view('bank-legacy.index');
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

        $post = BankLegacy::updateOrCreate(['id' => $id],[
            'nama_bank_legacy' => $request->nama_bank_legacy,
        ]);

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankLegacy  $bankLegacy
     * @return \Illuminate\Http\Response
     */
    public function show(BankLegacy $bankLegacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankLegacy  $bankLegacy
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = BankLegacy::where($where)->first();

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankLegacy  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankLegacy $jabatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankLegacy  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BankLegacy::where('id', $id)->delete();

        return response()->json($post);
    }
}
