<?php

namespace App\Http\Controllers;

use App\Cache;
use App\Contact;
use App\DefaultMessage;
use App\Message;
use App\Structure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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

        $structure = Structure::where('id', session()->get('id'))->first();

        $destinataires = count(Contact::where('structure_id', session()->get('id'))->get());

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

                    if ((Str::length($request->get('message'))) > 350) {
                        return back()->with('error', 'Votre message est trop long');
                    } else {
    
                        if ($destinataires == 0){
                            return back()->with('error', 'Le message n\'a pas de destinataires');
                        } else {

                            $structure->update([
                                'message_payer' => $structure->message_payer - $verify_nombresms
                            ]);

                            session()->put('message_payer', $structure->message_payer - $verify_nombresms);
        
                            $contacts = Contact::where('structure_id', session()->get('id'))->get();
        
                            foreach ($contacts as $contact)
                            {
                                $message = Str::upper($structure->name) .' : Cher(e) ' . $contact->name . ', ' . $request->get('message');
        
                                ?>
                                <script src="https://www.ibtagroup.com/js/jquery.js"></script>
                                <script>
                                    $(document).ready(function () {
                                        let myMessage = "<?= $message ?>";
                                        
                                        let newMessage = myMessage.replaceAll("è", "e");
                                        newMessage = newMessage.replaceAll("é", "e");
                                        newMessage = newMessage.replaceAll("ê", "e");
                                        newMessage = newMessage.replaceAll("ë", "e");
                                        newMessage = newMessage.replaceAll("î", "i");
                                        newMessage = newMessage.replaceAll("ï", "i");
                                        newMessage = newMessage.replaceAll("ù", "u");
                                        newMessage = newMessage.replaceAll("û", "u");
                                        newMessage = newMessage.replaceAll("ò", "o");
                                        newMessage = newMessage.replaceAll("ô", "o");
                                        newMessage = newMessage.replaceAll("ç", "c");
                                        newMessage = newMessage.replaceAll("â", "a");
                                        newMessage = newMessage.replaceAll("à", "a");
                                        newMessage = newMessage.replaceAll("%", "%25");
                                        newMessage = newMessage.replaceAll("&", "%26");
                                        newMessage = newMessage.replaceAll("(", "%28");
                                        newMessage = newMessage.replaceAll(")", "%29");
                                        newMessage = newMessage.replaceAll("*", "%2A");
                                        newMessage = newMessage.replaceAll("+", "%2B");
                                        newMessage = newMessage.replaceAll(";", "%3B");
                                        newMessage = newMessage.replaceAll("<", "%3C");
                                        newMessage = newMessage.replaceAll("=", "%3D");
                                        newMessage = newMessage.replaceAll(">", "%3E");
                                        newMessage = newMessage.replaceAll("?", "%3F");
                                        newMessage = newMessage.replaceAll("[", "%5B");
                                        newMessage = newMessage.replaceAll("]", "%5D");
                                        newMessage = newMessage.replaceAll("^", "%5E");
                                        newMessage = newMessage.replaceAll("{", "%7B");
                                        newMessage = newMessage.replaceAll("|", "%7C");
                                        newMessage = newMessage.replaceAll("}", "%7D");
                                        newMessage = newMessage.replaceAll("~", "%7E");
                                        newMessage = newMessage.replaceAll("À", "A");
                                        newMessage = newMessage.replaceAll("Â", "A");
                                        newMessage = newMessage.replaceAll("Ç", "C");
                                        newMessage = newMessage.replaceAll("È", "E");
                                        newMessage = newMessage.replaceAll("É", "E");
                                        newMessage = newMessage.replaceAll("Ë", "E");
                                        newMessage = newMessage.replaceAll("Ê", "E");
                                        newMessage = newMessage.replaceAll("Î", "I");
                                        newMessage = newMessage.replaceAll("Ï", "I");
                                        newMessage = newMessage.replaceAll("Ô", "O");
                                        newMessage = newMessage.replaceAll("Ù", "U");
                                        newMessage = newMessage.replaceAll("Û", "U");
                                        newMessage = newMessage.replaceAll("É", "E");
                                        newMessage = newMessage.replaceAll("É", "E");
                                        newMessage = newMessage.replaceAll("É", "E");
                                        newMessage = newMessage.replaceAll("É", "E");
                                        $.ajax({
                                            type: "GET",
                                            url: "https://api.smszedekaa.com/api/v2/SendSMS?SenderId=DEBLAA&Message="+ newMessage +"&MobileNumbers=<?= '228' . $contact->number ?>&ApiKey=yAYu1Q7C9FKy/1dOOBSHvpcrTldsEHGHtM2NjcuF4iU=&ClientId=4460f3b0-3a6a-49f4-8cce-d5900b86723d",
                                        });
                                    });
                                </script>
        
                                <?php
        
                            }
        
                            echo '<!DOCTYPE html>
                            <html lang="fr">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                                <link rel="stylesheet" href="https://www.ibtagroup.com/css/bootstrap.css">
                                <link rel="stylesheet" href="https://www.ibtagroup.com/css/mdb.css">
                                <link rel="stylesheet" href="https://www.ibtagroup.com/css/mdb.lite.css">
                                <link rel="stylesheet" href="https://www.ibtagroup.com/css/styles.css">
                                <link rel="stylesheet" href="https://www.ibtagroup.com/css/app.css">
                                <link rel="stylesheet" href="https://www.ibtagroup.com/icofont/icofont.css">
                                <title>Deblaa</title>
                                <style>
                            
                                    body {
                                        font-family: comfortaa;
                                    }
                            
                                    @font-face {
                                        font-family: comfortaa;
                                        src: url("https://www.ibtagroup.com/fonts/Comfortaa-Regular.ttf");
                                    }
                                </style>
                            </head>
                            <body>
                                    
                                <div class="container">
                                    <div class="mt-5"></div>
                                    <div class="mt-5"></div>
                                    <div class="mt-5"></div>
                                    <div class="d-flex justify-content-center mt-5">
                                        <img src="https://www.ibtagroup.com/assets/images/gif2.gif" width="300">
                                    </div>
                                    <div class="row justify-content-center mt-4">
                                        <p class="text-center">Envoi en cours......veuillez patienter quelques secondes</p>
                                    </div>
                                </div>
                            
                                <script src="https://www.ibtagroup.com/js/jquery.js"></script>
                                <script src="https://www.ibtagroup.com/js/bootstrap.js"></script>
                                <script src="https://www.ibtagroup.com/js/mdb.js"></script>
                                <script src="https://www.ibtagroup.com/js/popper.js"></script>
                            </body>
                            </html>
                            ';
        
                            $message = Message::create([
                                'body' => $request->get('message'),
                                'structure_id' => session()->get('id'),
                                'destinataires' => $destinataires,
                                'paid' => 0
                            ]);
        
                            foreach ($contacts as $contact) {
                                Cache::create([
                                    'name' => $contact->name,
                                    'number' => $contact->number,
                                    'message_id' => $message->id,
                                    'structure_id' => session()->get('id')
                                ]);
        
                                $contact->delete();
                            }
                            ?>
                            <script>
        
                                setTimeout(() => {
                                    window.location = "https://www.ibtagroup.com/messages/bilan";
                                }, 4000);
        
                            </script>
                            <?php
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
}
