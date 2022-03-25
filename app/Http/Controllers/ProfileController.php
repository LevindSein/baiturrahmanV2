<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

            //Validator
            $input['username']          = strtolower($request->profil_username);
            $input['nama']              = $request->profil_name;
            $input['hp']                = str_replace(['-', '_'], '', $request->profil_hp);
            $input['alamat']            = $request->profil_address;
            $input['password_sekarang'] = $request->profil_password_now;
            $input['password_baru']     = $request->profil_password_new;

            Validator::make($input, [
                'username'          => 'required|max:100|alpha_num|unique:App\Models\User,username,'.$decrypted,
                'nama'              => 'required|string|max:100',
                'hp'                => 'required|numeric|digits_between:11,13',
                'alamat'            => 'required|string|max:255',
                'password_sekarang' => 'required|min:6',
                'password_baru'     => 'nullable|min:6',
            ])->validate();
            //End Validator

            try {
                $data = User::findOrFail($decrypted);
            } catch(ModelNotFoundException $e) {
                return response()->json(['error' => "Data lost."]);
            }

            $data->username = $input['username'];
            $data->name     = $input['nama'];
            $data->hp       = $input['hp'];
            $data->address  = $input['alamat'];

            $password = $data->password;

            if($request->profil_password_new){
                $data->password = Hash::make(sha1(md5($input['password_baru'])));
            }

            if(Hash::check(sha1(md5($input['password_sekarang'])), $password)){
                $data->save();
            }
            else{
                return response()->json(['error' => "Password sekarang tidak cocok."]);
            }

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
