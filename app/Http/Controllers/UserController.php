<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index(){
        $data = [
            'title' => 'User',
            'page_title' => 'User List'
        ];
        return view('user.index', $data);
    }

    public function dtable(Request $request){
        if ($request->ajax()) {
            $user = User::all();
            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('created_at', function ($user) {
                    return $user->created_at->format("Y.m.d");
                })
                ->addColumn('updated_at', function ($user) {
                    return $user->updated_at->format("Y.m.d");
                })
                ->addColumn('action', function($row){
                    $actions = '';

                    if (\Gate::allows('is-developer')) {
                        $actions .= '<a href="javascript:void(0)" class="btn btn-success" onclick="show_modal_edit(\'modal_user\', '.$row->id.')">Edit</a>';
                        $actions .= ' <a href="javascript:void(0)" class="btn btn-danger" onclick="show_modal_delete('.$row->id.')">Delete</a>';
                    }

                    return $actions;
                })
                ->addColumn(("role"), function ($row){
                    $roles = $row->getRoleNames();
                    $result = implode(' | ', $roles->toArray());
                    return $result;
                })
                ->toJson();
        }
    }

    public function store(Request $request){
        try{
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            $user->role = $request->has('role') ? $request->input('role') : 'guest';
            $user->syncRoles($request->input('role'));
            return  response()->json([
                'status' => 'success',
                'message' => 'Successfully create user',
                'data' => $user,
            ], 200);
        }catch(\Throwable  $e){
            return response()->json([
                'status' => 'error',
                'message' => $e -> getMessage()
            ]);
        }

    }

    public function show($id){
        try{
            $user = User::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully create user',
                'data' => $user,
            ], 200);
        }catch(\Error $er){
            return response()->json([
                'status' => 'error',
                'message' => $er -> getMessage()
            ]);
        }
    }

    public function update(Request $request, $id){
        try{
            $user = User::find($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->role = $request->input('role', 'guest');
            $user->syncRoles($request->input('role'));

            return  response()->json([
                'status' => 'success',
                'message' => 'Successfully create user',
                'data' => $user,
            ], 200);
        }catch(\Throwable  $e){
            return response()->json([
                'status' => 'error',
                'message' => $e -> getMessage()
            ]);
        }

    }

}
