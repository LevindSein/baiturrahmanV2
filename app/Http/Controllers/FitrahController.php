<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Fitrah;
use App\Models\Period;
use App\Models\AnotherUser as Muzakki;
use App\Models\AnotherUser;
use App\Models\Rumusan;

use DataTables;

class FitrahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $period = Period::latest('id')->first();

            $data = Fitrah::select('id', 'code', 'muzakki', 'jumlah', 'status')
            ->where([
                ['status', 0],
                ['period_id', $period->id]
            ]);
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="edit btn btn-sm btn-clean btn-icon"><i class="fas fa-marker"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Hapus" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="delete btn btn-sm btn-clean btn-icon"><i class="fas fa-trash"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="detail btn btn-sm btn-clean btn-icon"><i class="fas fa-info"></i></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('Transaction.Fitrah.index');
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
    public function store(Request $request, $status)
    {
        if($request->ajax()){
            if($status == 0){
                //Validator
                $input['rumusan'] = $request->check_rumusan;
                $input['muzakki'] = $request->check_muzakki;

                Validator::make($input, [
                    'rumusan' => 'required|numeric|exists:App\Models\Rumusan,id',
                    'muzakki' => 'required|numeric|exists:App\Models\AnotherUser,id',
                ])->validate();
                //End Validator

                //Hitungan
                $data = array();
                try {
                    $rumusan = Rumusan::findOrFail($request->check_rumusan);
                    $muzakki = Muzakki::findOrFail($request->check_muzakki);
                } catch(ModelNotFoundException $err) {
                    return response()->json(['error' => "Data lost."]);
                }
                //End Hitungan

                $data['rumusan'] = json_decode($rumusan->rumus);
                $data['muzakki'] = $muzakki;

                $family = AnotherUser::where('family', $muzakki->id)->get();
                if($family){
                    $data['family'] = $family;
                }

                return response()->json(['success' => $data]);
            } else {
                //Submit Zakat Fitrah
                return response()->json(['success' => "Data berhasil disimpan."]);
            }
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
