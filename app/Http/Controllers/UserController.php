<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\User;
use App\Models\AnotherUser as Mustahik;

use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        if(request()->ajax()){
            $data = User::select('id','username','name','level')->where([
                ['status', $status],
                ['level', '<=', 2],
                ['id', '!=', Auth::id()]
            ]);
            return DataTables::of($data)
            ->addColumn('action', function($data) use ($status){
                $button = '';
                if(Auth::user()->id != $data->id){
                    if($status == 1){
                        $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.$data->id.'" nama="'.substr($data->name, 0, 15).'" class="edit btn btn-sm btn-clean btn-icon"><i class="fas fa-marker"></i></a>';
                        $button .= '<a type="button" data-toggle="tooltip" title="Reset Password" id="'.$data->id.'" nama="'.substr($data->name, 0, 15).'" class="reset btn btn-sm btn-clean btn-icon"><i class="fas fa-key-skeleton"></i></a>';
                        $button .= '<a type="button" data-toggle="tooltip" title="Nonaktifkan" id="'.$data->id.'" nama="'.substr($data->name, 0, 15).'" class="delete btn btn-sm btn-clean btn-icon"><i class="fas fa-times"></i></a>';
                    } else {
                        $button .= '<a type="button" data-toggle="tooltip" title="Aktifkan" id="'.$data->id.'" nama="'.substr($data->name, 0, 15).'" class="delete btn btn-sm btn-clean btn-icon"><i class="fas fa-check"></i></a>';
                    }
                    $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.$data->id.'" nama="'.substr($data->name, 0, 15).'" class="detail btn btn-sm btn-clean btn-icon"><i class="fas fa-info"></i></a>';
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
        if ($status <= 1)
            return view('Users.index', [
                'status' => $status,
                'title'  => ($status == 1) ? 'Pengguna Aktif' : 'Pengguna Nonaktif'
            ]);
        else
            abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($status)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $status)
    {
        if($request->ajax() && $status == 1){
            $request->validate([
                'tambah_username' => 'required|string|max:100|unique:App\Models\User,username',
                'tambah_name'     => 'required|string|max:100',
                'tambah_hp'       => 'required|numeric|digits_between:11,15|unique:App\Models\User,hp',
                'tambah_address'  => 'required|string|max:255',
                'tambah_level'    => 'required|numeric|digits_between:1,2',
            ]);

            User::insert([
                'username' => strtolower($request->tambah_username),
                'name'     => $request->tambah_name,
                'hp'       => $request->tambah_hp,
                'password' => Hash::make(sha1(md5(123456))),
                'address'  => $request->tambah_address,
                'level'    => $request->tambah_level,
                'status'   => 1
            ]);

            Mustahik::insert([
                'name'          => $request->tambah_name,
                'hp'            => $request->tambah_hp,
                'address'       => $request->tambah_address,
                'mustahik'      => 1,
                'stt_mustahik'  => 1,
                'type_mustahik' => 7,
            ]);

            return response()->json(['success' => 'Data berhasil ditambah.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($status, $id)
    {
        if(request()->ajax() && $status == 1){
            try {
                $data = User::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            return response()->json(['success' => $data]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($status, $id)
    {
        if(request()->ajax() && $status == 1){
            try {
                $data = User::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            return response()->json(['success' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $status, $id)
    {
        if($request->ajax() && $status == 1){
            $request->validate([
                'edit_name'     => 'required|string|max:100',
                'edit_hp'       => 'required|numeric|digits_between:11,15|unique:App\Models\User,hp,'.$id,
                'edit_address'  => 'required|string|max:255',
                'edit_level'    => 'required|numeric|digits_between:1,2'
            ]);

            try {
                $data = User::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data->update([
                'name'    => $request->edit_name,
                'hp'      => $request->edit_hp,
                'address' => $request->edit_address,
                'level'   => $request->edit_level
            ]);

            return response()->json(['success' => "Data berhasil disimpan."]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($status, $id)
    {
        if(request()->ajax()){
            try {
                $data = User::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            if($status == 1){
                $data->status = 0;
                $message = 'Data berhasil dinonaktifkan.';
            } else {
                $data->status = 1;
                $message = 'Data berhasil diaktifkan.';
            }

            $data->save();

            return response()->json(['success' => $message]);
        }
    }

    public function reset($status, $id)
    {
        if(request()->ajax() && $status == 1){
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
}
