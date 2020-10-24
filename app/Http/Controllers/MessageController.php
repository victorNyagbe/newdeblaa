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

        $numero = [];

        if ($structure != null) {

            if ((Str::of($request->get('message'))->trim()) != '') {

                if ($destinataires == 0){
                    return back()->with('error', 'Le message n\'a pas de destinataires');
                } else {

                    $contacts = Contact::where('structure_id', session()->get('id'))->get();

                    foreach ($contacts as $contact)
                    {
                        $message = Str::upper($structure->name) .' : Cher(e) ' . $contact->name . ',' . $request->get('message');

                        ?>
                        <script src="http://localhost/newdeblaa/public/js/jquery.js"></script>
                        <script>
                            $(document).ready(function () {
                                $.ajax({
                                    type: "GET",
                                    url: "http://dashboard.smszedekaa.com:6005/api/v2/SendSMS?SenderId=Deblaa&Message=<?= $message ?>&MobileNumbers=<?= '228' . $contact->number ?>&ApiKey=yAYu1Q7C9FKy/1dOOBSHvpcrTldsEHGHtM2NjcuF4iU=&ClientId=4460f3b0-3a6a-49f4-8cce-d5900b86723d",
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
                        <link rel="stylesheet" href="http://localhost/newdeblaa/public/css/bootstrap.css">
                        <link rel="stylesheet" href="http://localhost/newdeblaa/public/css/mdb.css">
                        <link rel="stylesheet" href="http://localhost/newdeblaa/public/css/mdb.lite.css">
                        <link rel="stylesheet" href="http://localhost/newdeblaa/public/css/styles.css">
                        <link rel="stylesheet" href="http://localhost/newdeblaa/public/css/app.css">
                        <link rel="stylesheet" href="http://localhost/newdeblaa/public/icofont/icofont.css">
                        <title>Deblaa</title>
                        <style>
                    
                            body {
                                font-family: comfortaa;
                            }
                    
                            @font-face {
                                font-family: comfortaa;
                                src: url("http://localhost/newdeblaa/public/fonts/Comfortaa-Regular.ttf");
                            }
                        </style>
                    </head>
                    <body>
                            
                        <div class="container">
                            <div class="mt-5"></div>
                            <div class="mt-5"></div>
                            <div class="mt-5"></div>
                            <div class="d-flex justify-content-center mt-5">
                                <img src="http://localhost/newdeblaa/public/assets/images/gif2.gif" width="300">
                            </div>
                            <div class="row justify-content-center mt-4">
                                <p class="text-center">Envoi en cours......veuillez patienter quelques secondes</p>
                            </div>
                        </div>
                    
                        <script src="http://localhost/newdeblaa/public/js/jquery.js"></script>
                        <script src="http://localhost/newdeblaa/public/js/bootstrap.js"></script>
                        <script src="http://localhost/newdeblaa/public/js/mdb.js"></script>
                        <script src="http://localhost/newdeblaa/public/js/popper.js"></script>
                    </body>
                    </html>
                    ';

                    $message = Message::create([
                        'body' => $request->get('message'),
                        'structure_id' => session()->get('id'),
                        'destinataires' => $destinataires
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
                            window.location = "http://localhost/newdeblaa/public/messages/bilan";
                        }, 4000);

                    </script>
                    <?php
                }
            } else {
                return back()->with('error', 'Vous ne pouvez pas envoyer un message vide !!!');
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
}
