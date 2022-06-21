<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAdministratorController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Login Administrator',
            
        ];
        return view('administrator.login',$data);
    }   

    public function aksiLoginAdm(Request $request)
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
            $request->session()->put('id_lokasi', 3);
            $request->session()->put('logout', 'Adm');
            return redirect()->route('welcome')->with('sukses', 'Login Berhasil');
        } else {
            return back()->with('error', 'Username/Password salah');
       }
        
    }

    public function logoutAdm(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('home');
    }
}