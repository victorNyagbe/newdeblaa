<?php

namespace App\Http\Controllers\Admin;

use App\CategorieTicket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategorieTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.admin');
    }
    public function index() 
    {
        $categories = CategorieTicket::all();
        $page = 'categorie_ticket';
        return view('admin.ticket.categorieTicket', compact('page', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categorie_tickets,nom',
            'nombre_sms' => 'required',
            'montant' => 'required',
            'couleur' => 'required'
        ]);

        CategorieTicket::create([
            'nom' => $request->input('name'),
            'montant' => $request->input('montant'),
            'nombre_sms' => intval($request->input('nombre_sms')),
            'code_couleur' => $request->input('couleur')
        ]);

        return back()->with('success', 'La catégorie "' . $request->input('name') . '" a été enregistrée avec succès');
    }

    public function destroy(CategorieTicket $categorieTicket)
    {
        $name = $categorieTicket->nom;
        $categorieTicket->delete();

        return back()->with('success', 'La catégorie "' . $name . '" a été supprimée avec succès');
    }
}
