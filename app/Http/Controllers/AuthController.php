<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->level == 1){
                return redirect('production/dashboard/rumusan')->with('success',"Selamat Datang $user->name.");
            }
            else if($user->level == 2){
                return redirect('production/dashboard/muzakki')->with('success',"Selamat Datang $user->name.");
            }
            else{
                return redirect('login')->with('warning', 'Harap Login.');
            }
        }

        return view('welcome');
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
                'username' => 'required|max:100',
                'password' => 'required|min:6',
            ]);

            $credentials['username'] = strtolower($request->username);
            $credentials['password'] = sha1(md5($request->password));
            if(Auth::attempt($credentials)) {
                $user = Auth::user();
                if (($user->level == 1 || $user->level == 2) && $user->status == 1){
                    return response()->json(['success' => "Akses Sukses."]);
                }
                else{
                    $temp = Session::get("_token");
                    Session::flush();
                    Session::put('_token', $temp);
                    Auth::logout();
                    return response()->json(['error' => "Akses Gagal."]);
                }
            }
            else{
                $temp = Session::get("_token");
                Session::flush();
                Session::put('_token', $temp);
                Auth::logout();
                return response()->json(['error' => "Username / Password Salah."]);
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

    public function logout()
    {
        $temp = Session::get("_token");
        Session::flush();
        Session::put('_token', $temp);
        Auth::logout();
        return Redirect('login');
    }
}
