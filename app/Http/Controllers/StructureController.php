<?php

namespace App\Http\Controllers;

use App\Cache;
use App\Ticket;
use App\Contact;
use App\Facture;
use App\Message;
use App\Structure;
use App\DefaultMessage;
use App\CategorieTicket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StructureController extends Controller
{

    public function __construct()
    {
        $this->middleware('check.structure')->except(['loginForm', 'login', 'bilan']);
    }

    public function index()
    {
        // $contacts = Contact::where([
        //     ['structure_id', session()->get('id')],
        //     ['permanent', 0]
        // ])->get();
        return view('structure.panel');
    }

    public function createContact()
    {
        $contacts = Contact::where([
            ['structure_id', session()->get('id')],
            ['permanent', 0]
        ])->get();
        return view('structure.createContact', compact('contacts'));
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
                session()->put('message_payer', $struc->message_payer);

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
        $default_messages = $this->defaultMessage();

        $contacts = Contact::where('structure_id', session()->get('id'))->get();

        return view('structure.message', compact('default_messages', 'contacts'));
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
            'newpassword' => 'required|confirmed|string|min:4',
            'oldpassword' => 'required'
        ], [
            'oldpassword.required' => 'Veuillez renseigner l\'ancien mot de passe',
            'newpassword.required' => 'Veuillez renseigner le nouveau mot de passe',
            'newpassword.string' => 'Le nouveau mot de passe doit être une chaîne de caractères',
            'newpassword.min' => 'Votre nouveau mot de passe doit contenir au minimum 4 caractères',
            'newpassword.confirmed' => 'Erreur de confirmation de mot de passe. les mots de passe ne sont pas identique'
        ]);

        if ((Str::of($request->get('newpassword'))->trim()) == '') {
            return back()->with('error', 'Le nouveau mot de passe que vous avez saisi est invalide');
        } else {
            if (Hash::check($request->get('oldpassword'), $structure->password)) {

                $structure->update([
                    'password' => Hash::make($request->get('newpassword'))
                ]);

                return back()->with('success', 'Mot de passe modifié avec succès');
            } else {
                return back()->with('error', 'Erreur! Ancien mot de passe erroné');
            }
        }

    }

    public function bilan()
    {
        
        $bilans = Message::where('structure_id', session()->get('id'))->orderByDesc('id')->get();

        return view('structure.bilan', compact('bilans'));
    }

    public function show_bilan($message_id)
    {
        $message = Message::where('structure_id', session()->get('id'))->findOrFail($message_id);

        $cacheContacts = Cache::where([
            ['structure_id', session()->get('id')],
            ['message_id', $message_id]
        ])->get();

        return view('structure.show_bilan', compact('cacheContacts', 'message'));
    }

    public function renvoyer_message(Request $request)
    {
        $findMessage = Message::where('structure_id', session()->get('id'))->find(substr($request->get('msgi'), 1));

        if ($findMessage != null) {
            $cacheContacts = Cache::where([
                ['structure_id', session()->get('id')],
                ['message_id', $findMessage->id]
            ])->get();

            foreach ($cacheContacts as $contact) {

                $rechercher_contact = Contact::where([
                    ['number', $contact->number],
                    ['structure_id', session()->get('id')]
                ])->get();

                if(count($rechercher_contact) == 0) {
                    Contact::create([
                        'name' => $contact->name,
                        'number' => $contact->number,
                        'structure_id' => session()->get('id')
                    ]);
                }
            }
            
            $default_messages = $this->defaultMessage();
        
            return view('structure.message', compact('default_messages'));

        } else {
            return redirect()->route('messages.bilan',)->with('error', 'Impossible d\'envoyer un message. Une erreur s\'est produite');
        }
    }

    public function destroyDefaultMessage(DefaultMessage $defaultMessage)
    {
        if ($defaultMessage->structure_id != session()->get('id')) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce message');
        } else {
            $defaultMessage->delete();

            return back()->with('success', 'Le message a été supprimé avec succès');
        }
    }

    protected function defaultMessage()
    {
        $default_messages = DefaultMessage::whereIn('structure_id', [0, intval(session()->get('id'))])->get();

        return $default_messages;
    }

    // public function index_stat()
    // {
    //     $statistiques = Message::where([
    //         ['structure_id', session()->get('id')],
    //         ['paid', 0]
    //     ])->orderByDesc('id')->get();

    //     return view('structure.statistiques.index', compact('statistiques'));
    // }

    // public function factures_index()
    // {
    //     $factures = Facture::where('structure_id', session()->get('id'))->get();
    //     return view('structure.statistiques.factureIndex', compact('factures'));
    // }

    // public function facture_show(Facture $facture)
    // {
    //     if ($facture->structure_id != session()->get('id')) {
    //         return back()->with('error', 'Désolé, une erreur s\'est produite. Vous ne pouvez pas voir les détails de cette facture');
    //     } else {
    //         $messages = DB::table('completions')
    //             ->join('factures', 'completions.facture_id', '=', 'factures.id')
    //             ->join('messages', 'completions.message_id', '=', 'messages.id')
    //             ->select('messages.*')
    //             ->where('factures.numero', '=', $facture->numero)
    //             ->get();
    //         return view('structure.statistiques.factureShow', compact('facture', 'messages'));
    //     }
    // }

    public function ticket()
    {
        return view('structure.ticket');
    }

    public function valider_ticket(Request $request)
    {
        $request->validate([
            'code_ticket' => 'required'
        ], 
        [
            'code_ticket.required' => 'Veuillez renseigner le code du ticket avant validation'
        ]);

        $ticket_exists = Ticket::where([
            ['code', '=', $request->input('code_ticket')],
            ['deleted_at', '=', null]
        ])->first();

        if ($ticket_exists == null) {
            return redirect()->back()->with('error', 'Opération non validée. Votre code ticket est invalide');
        } else {
            $sms = CategorieTicket::where('id', $ticket_exists->categorie_ticket_id)->get('nombre_sms')->first()->nombre_sms;
            $montant = CategorieTicket::where('id', $ticket_exists->categorie_ticket_id)->get('montant')->first()->montant;
            $ticket_exists->update([
                'structure_id' => session()->get('id')
            ]);
            $ticket_deleted = Ticket::where('code', $request->input('code_ticket'))->delete();

            $structure = Structure::where('id', session()->get('id'))->first();

            $struc_message = $structure->message_payer;
            $total_struc_message = intval($struc_message) + intval($sms);
            $structure->update([
                'message_payer' => $total_struc_message
            ]);
            session()->put('message_payer', $total_struc_message);

            return back()->with('success', 'Opération validée. vous avez fait une recharge de ' . $montant . ' FCFA soit ' . $sms . ' SMS');
        }
    }

}
