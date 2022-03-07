<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Rumusan;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Rumusan::get();
        return view('Dashboard.index', [
            'data'  => $data
        ]);
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
            return response()->json(['success' => "Data berhasil ditambah."]);
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
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            try{
                $data = Rumusan::findOrFail($decrypted);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data = json_decode($data->rumus);

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
            if($id == 'all'){

            } else {
                try {
                    $decrypted = Crypt::decrypt($id);
                } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                    return response()->json(['error' => "Data tidak valid."]);
                }

                try{
                    $data = Rumusan::findOrFail($decrypted);
                } catch (ModelNotFoundException $e) {
                    return response()->json(['error' => "Data lost."]);
                }

                $rumus = json_decode($data->rumus);

                $data->rumus = json_encode([
                    'satuan' => $request->edit_satuan,
                    'rupiah' => $rumus->rupiah,
                    'jiwa'   => $rumus->jiwa
                ]);

                $data->save();

                return response()->json(['success' => "Data berhasil disimpan."]);
            }
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
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            try{
                $data = Rumusan::findOrFail($decrypted);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data->deleted();

            return response(['success' => "Data berhasil dihapus."]);
        }
    }
}
