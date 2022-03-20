<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AnotherUser;

class SearchController extends Controller
{
    public function anotherUser(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = AnotherUser::select('id', 'name', 'hp','family')
            ->where([
                ['family', null],
                ['status', 1]
            ])
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
