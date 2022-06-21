<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function welcome(Request $request)
    {
        $data = [
            'title' => 'Welcome',
            'logout' => $request->session()->get('logout'),
        ];

        if (@Auth::user()->jenis == 'adm') {
            return view('welcome', $data);
        } else {
            $request->session()->flush();
            return redirect()->route('home')->with('error', 'Gagal masuk');;
        }
    }
}
