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
        $contact = Contact::create([
            'name' => $request->get('name'),
            'number' => $request->get('number'),
            'structure_id' => session()->get('id')
        ]);

        if($contact) {
            $contacts = Contact::where('structure_id', session()->get('id'))->get();

            return response()->json($contacts);
        }
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        $contacts = Contact::where('structure_id', session()->get('id'))->get();

        return response()->json($contacts);
    }
}
