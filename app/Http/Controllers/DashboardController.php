<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

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
        $data = Rumusan::orderBy('kategori', 'asc')->get();
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
            $request->validate([
                'tambah_satuan' => 'required|max:100',
                'tambah_alternatif' => 'required|max:100',
            ]);

            $i = 0;
            $data = Rumusan::select('id', 'kategori')->get();

            if($data->count() == 10){
                return response()->json(['warning' => "Kategori terlalu banyak, harap hapus sebagian."]);
            }

            $kategori = array();

            foreach ($data as $d) {
                $kategori[$i] = $d->kategori;
                $i++;
            }

            $data = $kategori;

            $kategori = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

            $data = array_diff($kategori, $data);

            $kategori = reset($data);

            Rumusan::create([
                'kategori' => $kategori,
                'rumus'    => json_encode([
                    'satuan'     => $request->tambah_satuan,
                    'alternatif' => $request->tambah_alternatif,
                    'rupiah'     => null,
                    'jiwa'       => null
                ])
            ]);

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

                foreach ($request->rumus_id_hidden as $rumus_id) {
                    $rumus_rupiah = "rumus_rupiah_$rumus_id";
                    $rumus_satuan = "rumus_satuan_$rumus_id";

                    $rupiah = "rumus_rupiah_$rumus_id";
                    $data[$rumus_rupiah] = intval(str_replace('.', '', $request->$rupiah));
                    $satuan = "rumus_satuan_$rumus_id";
                    $satuan = str_replace('.', '', $request->$satuan);
                    $data[$rumus_satuan] = intval(str_replace(',', '', $satuan));

                    Validator::make($data, [
                        $rumus_rupiah => 'required|numeric|lte:999999999',
                        $rumus_satuan => 'required|numeric|lte:99999999999',
                    ])->validate();

                    try{
                        $rumus = Rumusan::findOrFail($rumus_id);
                    } catch (ModelNotFoundException $e) {
                        return response()->json(['error' => "Data lost."]);
                    }

                    $json = json_decode($rumus->rumus);

                    $rupiah = "rumus_rupiah_$rumus_id";
                    $json->rupiah = intval(str_replace('.', '', $request->$rupiah));
                    $satuan = "rumus_satuan_$rumus_id";
                    $satuan = str_replace('.', '', $request->$satuan);
                    $json->jiwa = floatval(str_replace(',', '.', $satuan));

                    $json = json_encode($json);

                    $rumus->rumus = $json;

                    $rumus->save();
                }

                return response()->json(['success' => "Data berhasil disimpan."]);
            } else {
                $request->validate([
                    'edit_satuan' => 'required|max:100',
                    'edit_alternatif' => 'required|max:100',
                ]);

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
                    'satuan'     => $request->edit_satuan,
                    'alternatif' => $request->edit_alternatif,
                    'rupiah'     => $rumus->rupiah,
                    'jiwa'       => $rumus->jiwa
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

            $data->delete();

            // $reset = Rumusan::select('id','kategori')->get();
            // $i = 0;
            // foreach ($reset as $d) {
            //     $i++;
            //     $d->kategori = $i;
            //     $d->save();
            // }

            return response(['success' => "Data berhasil dihapus."]);
        }
    }
}
