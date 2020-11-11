<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.admin');
    }
    
    public function home()
    {
        $page = 'adminhome';
        return view('admin.index', compact('page'));
    }

    public function structure()
    {
        $structures = Structure::with('messages')->get();
        $page = 'structure';
        return view('admin.structure', compact('structures', 'page'));
    }

    public function registerStructure(Request $request)
    {
        $request->validate([
            'structure_name' => 'required|unique:structures,name',
            'pwd' => 'required|confirmed|string'
        ]);

        Structure::create([
            'name' => $request->get('structure_name'),
            'password' => Hash::make($request->get('pwd')),
            'message_payer' => 0
        ]);

        return redirect()->route('admin.structures')->with('success', 'La structure a été ajoutée avec succès');
    }
}
