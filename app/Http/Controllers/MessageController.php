<?php

namespace App\Http\Controllers;

use App\Cache;
use App\Sender;
use App\Contact;
use App\Message;
use App\Structure;
use App\DefaultMessage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.structure');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ], [
            'message.required' => 'Votre message est requis pour cette opération'
        ]);

        $id_struc = session()->get('id');

        $structure = Structure::where('id', session()->get('id'))->first();

        $destinataires = count(Contact::where([
            ['structure_id', session()->get('id')],
            ['permanent', 0]
        ])->get());

        $nbre_caractere = Str::length($request->get('message'));

        if ($nbre_caractere > 350) {
            return back()->with('error', 'Votre message est trop long');
        }

        $verify_nombresms = $this->getNombrePageSms($nbre_caractere) * $destinataires;

        if ($structure != null) {

            if (session()->get('message_payer')  == 0) {
                return back()->with('error', 'Veuillez recharger votre compte pour pouvoir effectuer cette opération.');
            } elseif ($structure->message_payer < $verify_nombresms) {
                return back()->with('error', 'Désolé! vous n\'avez pas assez de sms pour pouvoir effectuer cette opération. Veuillez recharger votre compte.');
            } else {
                if ((Str::of($request->get('message'))->trim()) != '') {

                        if (session()->has('contactsParGroupe')) {
                            $contactsParGroupe = session()->get('contactsParGroupe');

                            $nombreDesContacts = count($contactsParGroupe);

                            $nombreSms = $this->getNombrePageSms($nbre_caractere) * $nombreDesContacts;

                            if ($structure->message_payer < $nombreSms) {
                                return back()->with('error', 'Désolé! vous n\'avez pas assez de sms pour pouvoir effectuer cette opération. Veuillez recharger votre compte. Puis à nouveau sélectionner vos contacts.');
                                session()->forget('contactsParGroupe');
                            }

                            $structure->update([
                                'message_payer' => $structure->message_payer - $nombreSms
                            ]);

                            session()->put('message_payer', $structure->message_payer - $nombreSms);

                            $api_contactsParGroupe = new Sender("DEBLAA");
        
                            foreach ($contactsParGroupe as $contactParGroupe)
                            {
                                $query = Contact::where('number', $contactParGroupe)->first();

                                $message = Str::upper($structure->name) .' : Cher(e) ' . $query->name . ', ' . $request->get('message');

                                $api_contactsParGroupe->Submit($message, '228'.$contactParGroupe, "yAYu1Q7C9FKy/1dOOBSHvpcrTldsEHGHtM2NjcuF4iU=", "4460f3b0-3a6a-49f4-8cce-d5900b86723d");
                            }

                            session()->forget('contactsParGroupe');

                            $this->storeMessageIntoDatabase($request->get('message'), session()->get('id'), $nombreDesContacts, 0);

                            return redirect()->route('messages.bilan')->with('success', 'votre message a été envoyé avec succès');

                        }

                        if (session()->has('groups')) {
                            $all_numbers = [];
                            $groups =  session()->get('groups');

                            foreach ($groups as $group) {
                                $telephoneIds = DB::table('contact_group')->where('group_id', intval($group))->get();
                                
                                foreach ($telephoneIds as $telephoneId) {
                                    $telephoneNumber = Contact::where([
                                        ['structure_id', session()->get('id')],
                                        ['id', intval($telephoneId->contact_id)]
                                    ])->value('number');

                                    $all_numbers[] = $telephoneNumber;
                                }
                            }

                            $all_numbers = array_unique($all_numbers);

                            $countAllNumbers = count($all_numbers);

                            $countSms = $this->getNombrePageSms($nbre_caractere) * $countAllNumbers;

                            if ($structure->message_payer < $countSms) {
                                return back()->with('error', 'Désolé! vous n\'avez pas assez de sms pour pouvoir effectuer cette opération. Veuillez recharger votre compte. Puis à nouveau sélectionner vos contacts.');
                                session()->forget('groups');
                            }

                            $structure->update([
                                'message_payer' => $structure->message_payer - $countSms
                            ]);

                            session()->put('message_payer', $structure->message_payer - $countSms);

                            $api_allNumbers = new Sender("DEBLAA");
        
                            foreach ($all_numbers as $number)
                            {
                                $query = Contact::where('number', $number)->first();

                                $message = Str::upper($structure->name) .' : Cher(e) ' . $query->name . ', ' . $request->get('message');

                                $api_allNumbers->Submit($message, '228'.$all_numbers, "yAYu1Q7C9FKy/1dOOBSHvpcrTldsEHGHtM2NjcuF4iU=", "4460f3b0-3a6a-49f4-8cce-d5900b86723d");
                            }

                            session()->forget('groups');

                            $this->storeMessageIntoDatabase($request->get('message'), session()->get('id'), $countAllNumbers, 0);

                            return redirect()->route('messages.bilan')->with('success', 'votre message a été envoyé avec succès');
                        
                        }

                        if (session()->has('mes-contacts')) {
                            $contacts = session()->get('mes-contacts');

                            $nombre_contact = count($contacts);

                            $nombreSmsARetrancher = $this->getNombrePageSms($nbre_caractere) * $nombre_contact;

                            if ($structure->message_payer < $nombreSmsARetrancher) {
                                return back()->with('error', 'Désolé! vous n\'avez pas assez de sms pour pouvoir effectuer cette opération. Veuillez recharger votre compte. Puis à nouveau sélectionner vos contacts.');
                                session()->forget('mes-contacts');
                            }

                            $structure->update([
                                'message_payer' => $structure->message_payer - $nombreSmsARetrancher
                            ]);

                            session()->put('message_payer', $structure->message_payer - $nombreSmsARetrancher);

                            $api_contactsPermanents = new Sender("DEBLAA");
        
                            foreach ($contacts as $contact)
                            {
                                $query = Contact::where('number', $contact)->first();

                                $message = Str::upper($structure->name) .' : Cher(e) ' . $query->name . ', ' . $request->get('message');

                                $api_contactsPermanents->Submit($message, '228'.$contact, "yAYu1Q7C9FKy/1dOOBSHvpcrTldsEHGHtM2NjcuF4iU=", "4460f3b0-3a6a-49f4-8cce-d5900b86723d");
                            }

                            session()->forget('mes-contacts');

                            $this->storeMessageIntoDatabase($request->get('message'), session()->get('id'), $nombre_contact, 0);

                            return redirect()->route('messages.bilan')->with('success', 'votre message a été envoyé avec succès');

                        } else {
                            if ($destinataires == 0){
                                return back()->with('error', 'Le message n\'a pas de destinataires');
                            } else {
    
                                $structure->update([
                                    'message_payer' => $structure->message_payer - $verify_nombresms
                                ]);
    
                                session()->put('message_payer', $structure->message_payer - $verify_nombresms);
            
                                $contacts = Contact::where([
                                    ['structure_id', session()->get('id')],
                                    ['permanent', 0]
                                ])->get();
    
                                $api = new Sender("DEBLAA");
            
                                foreach ($contacts as $contact)
                                {
                                    $message = Str::upper($structure->name) .' : Cher(e) ' . $contact->name . ', ' . $request->get('message');
    
                                    $api->Submit($message, '228'.$contact->number, "yAYu1Q7C9FKy/1dOOBSHvpcrTldsEHGHtM2NjcuF4iU=", "4460f3b0-3a6a-49f4-8cce-d5900b86723d");
                                }
            
                                $message = $this->storeMessageIntoDatabase($request->get('message'), session()->get('id'), $destinataires, 0);
            
                                foreach ($contacts as $contact) {
                                    if ($contact->permanent == 0) {
                                        Cache::create([
                                            'name' => $contact->name,
                                            'number' => $contact->number,
                                            'message_id' => $message->id,
                                            'structure_id' => session()->get('id')
                                        ]);
                
                                        $contact->delete();
                                    }
                                }
                              
                                return redirect()->route('messages.bilan')->with('success', 'votre message a été envoyé avec succès');
                                
                            }
                        }
    
                } else {
                    return back()->with('error', 'Vous ne pouvez pas envoyer un message vide !!!');
                } 
            }
  
        } else {
            return redirect()->route('structure.loginForm');
        }

    }

    public function storeDefaultMessage(Request $request)
    {
        $request->validate([
            'defaultMessage' => 'required'
        ],[
            'defaultMessage.required' => 'Veuillez saisir dans le champ'
        ]);

        DefaultMessage::create([
            'content' => $request->get('defaultMessage'),
            'structure_id' => session()->get('id')
        ]);

        return redirect()->route('structure.message')->with('success', 'Votre message par défaut a été enregistré');
    }

    private function getNombrePageSms(int $nombre_caractere)
    {
        if ($nombre_caractere > 160) {
            return 2;
        } else {
            return 1;
        }
    }

    private function storeMessageIntoDatabase(string $message, int $structureId, int $destinataires, int $facturePaid)
    {
        $message = Message::create([
            'body' => $message,
            'structure_id' => $structureId,
            'destinataires' => $destinataires,
            'paid' => $facturePaid
        ]);

        return $message;
    }
}
