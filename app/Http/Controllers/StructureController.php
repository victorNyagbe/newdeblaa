<?php

namespace App\Http\Controllers;

use App\DefaultMessage;
use App\Message;
use App\Structure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StructureController extends Controller
{

    public function __construct()
    {
        $this->middleware('check.structure')->except(['loginForm', 'login']);
    }

    public function index()
    {
        return view('structure.index');
    }

    public function loginForm()
    {
        return view('structure.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string'
        ]);

        $struc = Structure::where('name', $request->get('name'))->first();

        if ($struc == null) {
            return back()->with('error', 'Le nom de la structure est incorrect');
        } else {
            if (Hash::check($request->get('password'), $struc->password)) {

                session()->put('id', $struc->id);
                session()->put('name', $struc->name);
                session()->put('image', $struc->image);
                session()->put('category', 'structure');

                return redirect()->route('structure.index');
            } else {
                return back()->with('error', 'Mot de passe incorrect');
            }
        }
    }

    public function logout()
    {
        session()->flush();

        return redirect()->route('structure.loginForm');
    }

    public function message()
    {
        $default_messages = DefaultMessage::whereIn('structure_id', [0, intval(session()->get('id'))])->get();
        return view('structure.message', compact('default_messages'));
    }

    public function show_profile()
    {
        return view('structure.profil');
    }

    public function update_profile(Request $request, Structure $structure)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'sometimes|file|image|mimes:png,jpg,jpeg'
        ],
        [
            'name.required' => 'Veuillez renseigner le nom de la structure',
            'name.string' => 'Le nom de la structure doit être une chaîne de caractères',
            'image.file' => 'Veuillez choisir un fichier',
            'image.image' => 'Votre fichier n\'est pas une image',
            'image.mimes' => 'Choisir une image en format jpg, jpeg ou png'
        ]);

        if ((Str::of($request->get('name'))->trim()) == '') {
            return back()->with('error', 'Le nom que vous avez saisi est invalide');
        }

        $structure->update([
            'name' => $request->get('name')
        ]);

        if ($request->has('image')) {
            $structure->update([
                'image' => $request->image->storeAs('assets/structures/logos/', time() . "_" . $request->file('image')->getClientOriginalName(), 'public')
            ]);
            
            session()->put('image', $structure->image);
        }

        session()->put('name', $structure->name);

        return back()->with('success', 'Modification effectuée avec succès');
    }

    public function changePassword(Request $request, Structure $structure)
    {
        $request->validate([
            'password' => 'required|string|min:4'
        ], [
            'password.required' => 'Veuillez renseigner le mot de passe',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères',
            'password.min' => 'Votre mot de passe doit contenir au minimum 4 caractères',
        ]);

        if ((Str::of($request->get('password'))->trim()) == '') {
            return back()->with('error', 'Le mot de passe que vous avez saisi est invalide');
        }

        $structure->update([
            'password' => Hash::make($request->get('password'))
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès');
    }

    public function bilan()
    {
        $bilans = Message::where('structure_id', session()->get('id'))->orderByDesc('id')->get();

        return view('structure.bilan', compact('bilans'));
    }

}
