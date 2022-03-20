<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

            try {
                $data = User::findOrFail($decrypted);
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
    public function update(Request $request, $id)
    {
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            $request->validate([
                'profil_username'     => 'required|max:100|alpha_num|unique:App\Models\User,username,'.$decrypted,
                'profil_name'         => 'required|string|max:100',
                'profil_hp'           => 'required|numeric|digits_between:11,15',
                'profil_address'      => 'required|string|max:255',
                'profil_password_now' => 'required|min:6',
                'profil_password_new' => 'nullable|min:6',
            ]);

            try {
                $data = User::findOrFail($decrypted);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data->username = $request->profil_username;
            $data->name = $request->profil_name;
            $data->hp = $request->profil_hp;
            $data->address = $request->profil_address;

            if($request->profil_password_new){
                $data->password = Hash::make(sha1(md5($request->profil_password_new)));
            }

            $data->save();

            return response()->json(['success' => "Data berhasil disimpan."]);
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
        //
    }
}
