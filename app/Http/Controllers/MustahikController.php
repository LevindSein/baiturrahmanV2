<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            $data['mustahik']  = 1;
            $data['stt_mustahik']  = 1;
            $data['type_mustahik'] = $request->tambah_type;

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
}
