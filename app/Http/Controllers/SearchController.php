<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AnotherUser;
use App\Models\AnotherUser as Muzakki;

class SearchController extends Controller
{
    public function anotherUser(Request $request){
        $data = [];
        if($request->ajax()) {
            $data = AnotherUser::select('id', 'name', 'hp','family', 'stt_muzakki', 'stt_mustahik')
            ->where('stt_muzakki', 1)
            ->orWhere('stt_mustahik', 1)
            ->where(function ($query) use ($request) {
                $key = $request->q;
                $query->where('name', 'LIKE', '%'.$key.'%')
                      ->orWhere('hp', 'LIKE', '%'.$key.'%');
            })
            ->orderBy('name','asc')
            ->limit(10)
            ->get();
        }
        return response()->json($data);
    }

    public function anotherUserId(Request $request, $id){
        $data = [];
        if($request->ajax()) {
            $data = AnotherUser::select('id', 'name', 'hp', 'family', 'stt_muzakki', 'stt_mustahik')
            ->where(function ($query) use ($id) {
                $query
                ->where([
                    ['family', null],
                    ['stt_muzakki', 1],
                    ['id', '!=', $id],
                ])
                ->orWhere([
                    ['family', null],
                    ['stt_mustahik', 1],
                    ['id', '!=', $id],
                ]);
            })
            ->where(function ($query) use ($request) {
                $key = $request->q;
                $query
                ->where('name', 'LIKE', '%'.$key.'%')
                ->orWhere('hp', 'LIKE', '%'.$key.'%');
            })
            ->orderBy('name','asc')
            ->limit(10)
            ->get();
        }
        return response()->json($data);
    }

    public function muzakki(Request $request){
        $data = [];
        if($request->ajax()) {
            $data = Muzakki::select('id', 'name', 'hp', 'stt_muzakki')
            ->where('stt_muzakki', 1)
            ->where(function ($query) use ($request) {
                $key = $request->q;
                $query->where('name', 'LIKE', '%'.$key.'%')
                      ->orWhere('hp', 'LIKE', '%'.$key.'%');
            })
            ->orderBy('name','asc')
            ->limit(10)
            ->get();
        }
        return response()->json($data);
    }
}
