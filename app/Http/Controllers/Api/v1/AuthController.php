<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function prepare_to_login(Request $request){
        $state = str(random_bytes(40));

        $query = http_build_query([
            'client_id' => env('CLIENT_ID'),
            'redirect_url' => env('REDIRECT_URL'),
            'response_type' => 'code',
            'scope' => '', // Alterar dps
            'state' => $state,
        ]);

        return redirect('http://localhost:8000/oauth/authorize?'.$query);
    }

    public function callback(Request $request){
        dd($request->all());
        return response()->json($request->all());
    }
}
