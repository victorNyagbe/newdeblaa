<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    public function index() 
    {
        $page = $this->page();

        return view('admin.ticket.index', compact('page'));
    }

    public function persoIndex()
    {
        $persos = Ticket::where([
            ['categorie_ticket_id', 1],
            ['deleted_at', '=', null]
        ])->get();
        
        $page = $this->page();

        return view('admin.ticket.perso', compact('persos', 'page'));
    }

    public function storePerso(Request $request)
    {
        $request->validate([
            'categorie_id' => 'required'
        ]);

        Ticket::create([
            'categorie_ticket_id' => $request->input('categorie_id'),
            'code' => "TDB" . random_int(1000000, 9999998)
        ]);

        return back()->with('success', 'Un ticket perso a été crée avec succès');
    }

    public function proIndex()
    {
        $pros = Ticket::where([
            ['categorie_ticket_id', 2],
            ['deleted_at', '=', null]
        ])->get();
        
        $page = $this->page();

        return view('admin.ticket.pro', compact('pros', 'page'));
    }

    public function storePro(Request $request)
    {
        $request->validate([
            'categorie_id' => 'required'
        ]);

        Ticket::create([
            'categorie_ticket_id' => $request->input('categorie_id'),
            'code' => "TDB" . random_int(1000000, 9999998)
        ]);

        return back()->with('success', 'Un ticket pro a été crée avec succès');
    }

    public function proMaxIndex()
    {
        $promaxs = Ticket::where([
            ['categorie_ticket_id', 3],
            ['deleted_at', '=', null]
        ])->get();
        
        $page = $this->page();

        return view('admin.ticket.promax', compact('promaxs', 'page'));
    }

    public function storePromax(Request $request)
    {
        $request->validate([
            'categorie_id' => 'required'
        ]);

        Ticket::create([
            'categorie_ticket_id' => $request->input('categorie_id'),
            'code' => "TDB" . random_int(1000000, 9999998)
        ]);

        return back()->with('success', 'Un ticket pro max a été crée avec succès');
    }

    private function page()
    {
        return 'tickets';
    }
}
