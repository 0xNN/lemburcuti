<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request, User $model)
    {
        if ($request->ajax()) {
            $data = $model->all();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $button = '<div class="btn-group btn-group-sm" role="group">';
                        $button .= '<button type="button" name="delete" id="'.$row->id.'" class="delete btn btn-danger btn-sm"><i class="material-icons">delete</i></button>';
                        $button .= '</div>';
                        if($row->is_admin == 1)
                        {
                            return 'User Admin';
                        } else {
                            return $button;
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('users.index');
    }

    public function store(Request $request)
    {
        $id = $request->id;

        $user = User::updateOrCreate(['id' => $id],[
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $post = User::where('id', $id)->delete();

        return response()->json($post);
    }
}
