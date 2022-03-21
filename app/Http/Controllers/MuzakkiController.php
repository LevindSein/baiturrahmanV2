<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\AnotherUser as Muzakki;
use App\Models\AnotherUser;
use DataTables;

class MuzakkiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = Muzakki::select('id', 'name', 'muzakki', 'stt_muzakki')
            ->where([
                ['muzakki', 1],
                ['stt_muzakki', 1]
            ]);
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.$data->id.'" nama="'.substr($data->name, 0, 15).'" class="edit btn btn-sm btn-clean btn-icon"><i class="fas fa-marker"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Hapus" id="'.$data->id.'" nama="'.substr($data->name, 0, 15).'" class="delete btn btn-sm btn-clean btn-icon"><i class="fas fa-trash"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.$data->id.'" nama="'.substr($data->name, 0, 15).'" class="detail btn btn-sm btn-clean btn-icon"><i class="fas fa-info"></i></a>';
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
            ->rawColumns(['action','name'])
            ->make(true);
        }
        return view('Dashboard.Muzakki.index');
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
        if($request->ajax()){
            $request->validate([
                'tambah_name'     => 'required|string|max:100',
                'tambah_hp'       => 'required|numeric|digits_between:11,15|unique:App\Models\AnotherUser,hp',
                'tambah_address'  => 'required|string|max:255',
            ]);

            $data['name']     = $request->tambah_name;
            $data['hp']       = $request->tambah_hp;
            $data['address']  = $request->tambah_address;
            if($request->tambah_family){
                $data['family'] = $request->tambah_family;
            }
            $data['muzakki']  = 1;
            $data['stt_muzakki']  = 1;
            if($request->tambah_mustahik){
                $data['mustahik']      = 1;
                $data['stt_mustahik']  = 1;
                $data['type_mustahik'] = $request->tambah_type;
            }

            Muzakki::insert($data);

            return response()->json(['success' => 'Data berhasil ditambah.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(request()->ajax()){
            try {
                $data = Muzakki::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data['memberOf'] = null;
            if($data->family){
                try {
                    $memberOf = AnotherUser::findOrFail($data->family);
                } catch(ModelNotFoundException $e) {
                    return response()->json(['error' => "Data lost."]);
                }

                $data['memberOf'] = $memberOf;
            }

            $families = AnotherUser::where('family', $id)->select('id', 'name')->get();
            if($families->count() > 0){
                $data['families'] = $families;
            } else {
                $data['families'] = null;
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
    public function edit($id)
    {

        if(request()->ajax()){
            try {
                $data = Muzakki::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data['memberOf'] = null;
            if($data->family){
                try {
                    $memberOf = AnotherUser::findOrFail($data->family);
                } catch(ModelNotFoundException $e) {
                    return response()->json(['error' => "Data lost."]);
                }

                $data['memberOf'] = $memberOf;
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
    public function update(Request $request, $id)
    {
        if($request->ajax()){
            $request->validate([
                'edit_name'     => 'required|string|max:100',
                'edit_hp'       => 'required|numeric|digits_between:11,15|unique:App\Models\AnotherUser,hp,'.$id,
                'edit_address'  => 'required|string|max:255',
            ]);

            try {
                $data = Muzakki::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data->name     = $request->edit_name;
            $data->hp       = $request->edit_hp;
            $data->address  = $request->edit_address;
            if($request->edit_family){
                $data->family = $request->edit_family;
            } else {
                $data->family = null;
            }

            $data->save();

            return response()->json(['success' => 'Data berhasil ditambah.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(request()->ajax()){
            try {
                $data = Muzakki::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data->stt_muzakki = 0;

            $data->save();

            return response()->json(['success' => "Data berhasil dihapus."]);
        }
    }
}
