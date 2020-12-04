<?php

namespace App\Http\Controllers;

use App\Group;
use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.structure');
    }

    public function index()
    {
        $groups = Group::where('structure_id', session()->get('id'))->get();
        return view('structure.groups.index', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ],[
            'name.required' => 'Veuillez renseigner le nom du groupe',
            'name.string' => 'Votre nom est invalide'
        ]);

        $ExistOrNotGroup = Group::where([
            ['structure_id', session()->get('id')],
            ['name', $request->get('name')]
        ])->first();

        if ($ExistOrNotGroup == null) {
            Group::create([
                'name' => $request->get('name'),
                'structure_id' => session()->get('id')
            ]);
            return back()->with('success', 'Le groupe a été enregistré avec succès');
        } else {
            return back()->with('error', 'Ce groupe existe déjà');
        }
    }

    public function show(Group $group)
    {
        return view('structure.groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
        return view('structure.groups.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string'
        ],[
            'name.required' => 'Veuillez saisir le nom du groupe',
            'name.string' => 'Le nom est invalide'
        ]);

        $name = $group->name;

        if ($request->name == $name) {
            $group->update([
                'name' => $request->name
            ]);
            return back()->with('success', 'Le groupe a été modifié avec succès');
        } else {
            $rechercher_groupe = Group::where([
                ['structure_id', session()->get('id')],
                ['name', $request->get('name')]
            ])->first();

            if ($rechercher_groupe == null) {
                $group->update([
                    'name' => $request->name
                ]);
                return back()->with('success', 'Le groupe a été modifié avec succès');
            } else {
                return back()->with('error', 'Ce groupe existe déjà');
            }
        }
    }

    public function destroy(Group $group)
    {
        $groupId = $group->id;

        DB::table('contact_group')->where('group_id', $groupId)->delete();

        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Le groupe a été suprrimé avec succès');
    }

    public function addContactView(Group $group)
    {
        $contacts = Contact::where([
            ['structure_id', session()->get('id')],
            ['permanent', 1]
        ])->get();

        $contact_collections = collect([]);

        foreach ($contacts as $contact) {
            $contactsAlreadyInTheGroup = DB::table('contact_group')->where([
                ['group_id', $group->id],
                ['contact_id', $contact->id]
            ])->first();

            if ($contactsAlreadyInTheGroup == null) {
                $news_contact = [
                    "number" => $contact->number,
                    "name" => $contact->name
                ];
                $contact_collections->push($news_contact);
            }
        }

        return view('structure.groups.addContact', compact('group', 'contact_collections'));
    }

    public function addContactToGroup(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string',
            'number' => 'required|string'
        ], [
            'name.required' => 'Veuillez saisir le nom du correspondant',
            'name.string' => 'Le nom est invalide',
            'number.required' => 'Veuillez saisir le numéro du correspondant',
            'number.string' => 'Le numéro est invalide'
        ]);

        $rechercher_contact = Contact::where([
            ['number', $request->get('number')],
            ['structure_id', session()->get('id')]
        ])->first();

        if ($rechercher_contact == null) {

            $contact = Contact::create([
                'name' => $request->get('name'),
                'number' => $request->get('number'),
                'structure_id' => session()->get('id'),
                'permanent' => 1
            ]);

            DB::table('contact_group')->insert([
                'group_id' => $group->id,
                'contact_id' => $contact->id
            ]);

            return back()->with('success', 'Le contact a été enregistré et ajouté au groupe avec succès.');
        } else {
            return back()->with('error', 'Ce contact existe déjà dans votre liste de contact sous le nom '. $rechercher_contact->name . '. Vérifiez dans votre liste de contact');
        }
    }

    public function addListOfContactToGroup(Request $request, Group $group) 
    {
        $contactsSelected = $request->input('contactToBeChecked');

        if (count($contactsSelected) == 0) {
            return back()->with('error', 'Aucun contact n\'a été sélectionné. Veuillez séléctionner au moins un contact');
        } else {
            foreach ($contactsSelected as $contact) {
                $contactId = Contact::where([
                    ['number', $contact],
                    ['structure_id', session()->get('id')]
                ])->value('id');
                
                DB::table('contact_group')->insert([
                    'group_id' => $group->id,
                    'contact_id' => $contactId
                ]);
            }
            return back()->with('success', 'Le contacts sélectionnés ont été ajoutés au groupe avec succès.');
        }
    }

    public function sendMessageByIndividualGroup(Request $request)
    {
        $contacts = $request->input('contactToBeChecked');
        
        if ($contacts != null) {
            if (count($contacts) == 0){
                return back()->with('error', 'Aucun contact n\'a été sélectionné. Veuillez séléctionner au moins un contact');
            } else {
                session()->put('contactsParGroupe', $contacts);
                return redirect()->route('structure.message');
            }
        } else {
            return back()->with('error', 'Aucun contact n\'a été sélectionné. Veuillez séléctionner au moins un contact');
        }
    }

    public function sendMessageByGroups(Request $request)
    {
        $groups = $request->input('groups');

        if ($groups != null) {
            if (count($groups) == 0){
                return back()->with('error', 'Aucun groupe n\'a été sélectionné. Veuillez séléctionner au moins un groupe');
            } else {
                session()->put('groups', $groups);
                return redirect()->route('structure.message');
            }
        } else {
            return back()->with('error', 'Aucun groupe n\'a été sélectionné. Veuillez séléctionner au moins un groupe');
        }
    }
}
