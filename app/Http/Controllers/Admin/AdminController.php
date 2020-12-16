<?php

namespace App\Http\Controllers\Admin;

use App\Ticket;
use App\Message;
use App\Structure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $nombre_structures = Structure::count();
        $nombre_tickets = Ticket::count();
        $nombre_messages = Message::count();
        return view('admin.index', compact('page', 'nombre_messages', 'nombre_structures', 'nombre_tickets'));
    }

    public function structure()
    {
        $structures = Structure::with('messages')->get();
        $page = 'structure';
        return view('admin.structure.index', compact('structures', 'page'));
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
            'message_payer' => 20
        ]);

        return redirect()->route('admin.structures')->with('success', 'La structure a été ajoutée avec succès');
    }
}
