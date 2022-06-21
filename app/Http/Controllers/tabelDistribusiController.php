<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use Illuminate\Http\Request;

class tabelDistribusiController extends Controller
{
    public function index(Request $request)
    {    
        $data = [
            'title' => 'Distribusi',
            'logout' => $request->session()->get('logout'),
            'distribusi' => Distribusi::all()
        ];
        return view('distribusi.tabelDistribusi',$data);
    }

    
}
