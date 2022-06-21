<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginSoondobuController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Login Soondobu'
        ];
        return view('login.loginSoondobu',$data);
    }

    public function aksiLoginSdb(Request $request)
    {

        $data = [
            'username' => $request->username,
            'password' => $request->password,
            'jenis' => $request->jenis
        ];
        
        // $db = Login::where('username','=',$request->username)->get();

       if(Auth::attempt($data))
       {    
            $request->session()->regenerate();
            $request->session()->put('id_lokasi', 2);
            $request->session()->put('logout', 'Sdb');
            return redirect()->route('welcome')->with('sukses', 'Login Berhasil');
        } else {
            return back()->with('error', 'Username/Password salah');
       }
    }

    public function logoutSdb(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('home');
    }
}
