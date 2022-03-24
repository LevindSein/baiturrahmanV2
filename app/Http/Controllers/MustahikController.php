<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\AnotherUser as Mustahik;
use App\Models\AnotherUser;
use DataTables;

class MustahikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = Mustahik::select('id', 'name', 'mustahik', 'stt_mustahik')
            ->where([
                ['mustahik', 1],
                ['stt_mustahik', 1]
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
        return view('Dashboard.Mustahik.index');
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
            //Validator
            $input['nama']         = $request->tambah_name;
            $input['hp']           = str_replace(['-', '_'], '', $request->tambah_hp);
            $input['alamat']       = $request->tambah_address;
            $input['kategori']     = $request->tambah_type;
            $input['keluarga']     = $request->tambah_family;

            Validator::make($input, [
                'nama'             => 'required|string|max:10',
                'hp'               => 'required|numeric|digits_between:11,13',
                'alamat'           => 'required|string|max:255',
                'kategori'         => 'required|numeric|min:1|max:8',
                'keluarga'         => 'nullable|numeric'
            ])->validate();
            //End Validator

            $data['name']          = $input['nama'];
            $data['hp']            = $input['hp'];
            $data['address']       = $input['alamat'];

            if($request->tambah_family){
                $data['family']    = $input['keluarga'];
            }

            $data['mustahik']      = 1;
            $data['stt_mustahik']  = 1;
            $data['type_mustahik'] = $input['kategori'];

            Mustahik::insert($data);

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
                $data = Mustahik::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data['kategori'] = AnotherUser::kategori($data->type_mustahik);

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
                $data = Mustahik::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data['kategori'] = AnotherUser::kategori($data->type_mustahik);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->ajax()){
            //Validator
            $input['nama']       = $request->edit_name;
            $input['hp']         = str_replace(['-', '_'], '', $request->edit_hp);
            $input['alamat']     = $request->edit_address;
            $input['kategori']   = $request->edit_type;
            $input['keluarga']   = $request->edit_family;

            Validator::make($input, [
                'nama'           => 'required|string|max:100',
                'hp'             => 'required|numeric|digits_between:11,13',
                'alamat'         => 'required|string|max:255',
                'kategori'       => 'required|numeric|min:1|max:8',
                'keluarga'       => 'nullable|numeric'
            ])->validate();
            //End Validator

            try {
                $data = Mustahik::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data->name          = $input['nama'];
            $data->hp            = $input['hp'];
            $data->address       = $input['alamat'];
            $data->type_mustahik = $input['kategori'];

            if($request->edit_family){
                $data->family    = $input['keluarga'];
            } else {
                $data->family    = null;
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
                $data = Mustahik::findOrFail($id);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data->stt_mustahik = 0;

            $data->save();

            return response()->json(['success' => "Data berhasil dihapus."]);
        }
    }
}
