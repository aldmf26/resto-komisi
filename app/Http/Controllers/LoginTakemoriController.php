<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginTakemoriController extends Controller
{
    public function index()
    {

            $data = [
                'title' => 'Login Takemori',
            ];
            return view('login.loginTakemori',$data);
        
        
    }

    public function aksiLoginTkm(Request $request)
    {
     
        $data = [
            'username' => $request->username,
            'password' => $request->password,
            'jenis' => $request->jenis,     
        ];

       
        
        // $db = Login::where('username','=',$request->username)->get();

       if(Auth::attempt($data))
       {    
            $request->session()->regenerate();
            $request->session()->put('id_lokasi', 1);
            $request->session()->put('logout', 'Tkm');
            return redirect()->route('welcome')->with('sukses', 'Login Berhasil');
        } else {
            return back()->with('error', 'Username/Password salah');
       }
    }

    public function logoutTkm(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('home');
    }
}
