<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.structure');
    }

    public function index()
    {
        $contacts = Contact::where('structure_id', session()->get('id'))->get();

        return response()->json($contacts);
    }

    public function store(Request $request)
    {
        $rechercher_contact = Contact::where([
            ['number', $request->get('number')],
            ['structure_id', session()->get('id')]
        ])->get();

        if (count($rechercher_contact) == 0) {

            Contact::create([
                'name' => $request->get('name'),
                'number' => $request->get('number'),
                'structure_id' => session()->get('id')
            ]);
    
            return back()->with('success', 'Le contact a été enregistré avec succès');
        } else {
            return back()->with('error', 'Ce contact existe déjà.');
        }
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Le contact a été supprimé avec succès');
    }

    public function contact()
    {
        $contactPermanents = Contact::where([
            ['structure_id', session()->get('id')],
            ['permanent', 1]
        ])->orderBy('name')->get();
        return view('structure.contacts', compact('contactPermanents'));
    }

    public function contact_permanent(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'number' => 'required|string'
        ], [
            'name.required' => 'Veuillez saisir le nom du correspondant',
            'name.string' => 'Le nom est invalide',
            'number.required' => 'Veuillez saisir le numéro de téléphone du correspondant',
            'name.string' => 'Le numéro de téléphone est invalide'
        ]);

        $rechercher_contact = Contact::where([
            ['number', $request->get('number')],
            ['structure_id', session()->get('id')]
        ])->get();

        if (count($rechercher_contact) == 0) {

            Contact::create([
                'name' => $request->get('name'),
                'number' => $request->get('number'),
                'structure_id' => session()->get('id'),
                'permanent' => 1
            ]);
    
            return back()->with('success', 'Le contact a été enregistré avec succès');
        } else {
            return back()->with('error', 'Ce contact existe déjà.');
        }
    }

    public function contactPermanentLinkToMessage(Request $request)
    {
        $contacts = $request->input('contactToBeChecked');

        if ($contacts != null) {
            if (count($contacts) == 0) {
                return back()->with('error', 'Aucun contact n\'a été sélectionné. Veuillez séléctionner au moins un contact');
            } else {
                session()->put('mes-contacts', $contacts);
                return redirect()->route('structure.message');
            } 
        } else {
            return back()->with('error', 'Aucun contact n\'a été sélectionné. Veuillez séléctionner au moins un contact');
        }
    }

    public function editContactPermanent(Contact $contact)
    {
        return view('structure.editContact', compact('contact'));
    }

    public function updateContactPermanent(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required|string',
            'number' => 'required|string'
        ], [
            'name.required' => 'Veuillez saisir le nom du correspondant',
            'name.string' => 'Le nom est invalide',
            'number.required' => 'Veuillez saisir le numéro de téléphone du correspondant',
            'name.string' => 'Le numéro de téléphone est invalide'
        ]);

        $number = $contact->number;

        if($request->get('number') == $number) {
            $contact->update([
                'number' => $request->get('number'),
                'name' => $request->get('name')
            ]);
            return redirect()->route('structure.contact')->with('success', 'Le contact a été modifié avec succès');
        } else {
            $rechercher_contact = Contact::where([
                ['number', $request->get('number')],
                ['structure_id', session()->get('id')]
            ])->first();

            if ($rechercher_contact == null) {

                $contact->update([
                    'number' => $request->get('number'),
                    'name' => $request->get('name')
                ]);
        
                return redirect()->route('structure.contact')->with('success', 'Le contact a été modifié avec succès');
            } else {
                return redirect()->route('structure.contact')->with('error', 'Ce contact existe déjà.');
            }
        }
    }


    public function destroyPermanentContact(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('structure.contact')->with('success', 'Le contact a été supprimé avec succès');
    }
}
