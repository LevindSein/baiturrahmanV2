<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\User;

use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = User::select('id','username','name','level')->where([
                ['status', 1],
                ['id', '!=', Auth::id()]
            ]);
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '';
                    if(Auth::user()->id != $data->id){
                        $button  = '<a type="button" data-toggle="tooltip" title="Reset Password" id="'.$data->id.'" nama="'.substr($data->name, 0, 15).'" class="reset btn btn-sm btn-clean btn-icon"><i class="fas fa-sm fa-key"></i></a>';
                        $button .= '<a type="button" data-toggle="tooltip" title="Nonaktifkan" id="'.$data->id.'" nama="'.substr($data->name, 0, 15).'" class="nonaktif btn btn-sm btn-clean btn-icon"><i class="fas fa-sm fa-power-off"></i></a>';
                    }
                    return $button;
                })
                ->editColumn('level', function($data){
                    if($data->level == 1){
                        $button = '<span class="label label-lg font-weight-bold label-inline label-light-primary">Super Admin</span>';
                    }
                    else{
                        $button = '<span class="label label-lg font-weight-bold label-inline label-light-success">Admin</span>';
                    }
                    return $button;
                })
                ->editColumn('name', function($data){
                    $name = $data->name;
                    if(strlen($name) > 15) {
                        $name = substr($name, 0, 11);
                        $name = str_pad($name,  15, ".");
                        return "<span data-toggle='tooltip' title='$data->name'>$name</span>";
                    }
                    else{
                        return $name;
                    }
                })
                ->rawColumns(['action','level', 'name'])
                ->make(true);
        }
        return view('Users.Aktif.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reset($id)
    {
        if(request()->ajax()){
            try {
                $data = User::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data->password = Hash::make(sha1(md5(123456)));

            $data->save();

            return response()->json(['success' => 'Password di reset <b>123456</b>.']);
        }
    }

    public function nonaktif($id)
    {
        if(request()->ajax()){
            try {
                $data = User::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data->status = 0;

            $data->save();

            return response()->json(['success' => 'Data berhasil dinonaktifkan.']);
        }
    }
}
