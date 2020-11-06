<?php

namespace App\Http\Controllers\Admin;

use App\Facture;
use App\Message;
use App\Structure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FactureController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    public function statistique() 
    {
        $page = 'statistique_index';
        //Le tableau qui englobe tous les statistiques
        $tab = [];
        $structures = Structure::with('messages')->get();

        foreach ($structures as $structure) {
            $nbre_messages = 0;
            $destinataires = 0;

            if (count($structure->messages) != 0) {
                foreach ($structure->messages as $message) {
                
                    if ($message->paid == 0) {
                        $nbre_messages ++;
                        $destinataires += $message->destinataires;
                    } else {
                        $nbre_messages = $nbre_messages;
                        $destinataires = $destinataires;
                    }
                    //Le tableau qui renferme les statistiques des structures
                    $str_stat = [
                        'structure_id' => $structure->id,
                        'nom_structure' => $structure->name,
                        'nbre_messages' => $nbre_messages,
                        'destinataires' => $destinataires
                    ];
                }
                $tab[] = $str_stat;
            }
        }

        return view('admin.facture.statistique', compact('page', 'tab'));
    }

    public function statistique_show(Structure $structure)
    {
        $page = 'statistique_index';
        $statistiques = Message::where([
            ['structure_id', $structure->id],
            ['paid', 0]
        ])->orderByDesc('id')->get();
        $facture = Facture::orderByDesc('id')->first();
        if ($facture == null) {
            $numero_facture = '#DBL112879';
        } else {
            $numero_facture = intval(Str::substr($facture->numero, 4) ) + 1;
            $numero_facture = '#DBL' . $numero_facture;
        }
        return view('admin.facture.show_stat' , compact('page', 'structure', 'statistiques', 'numero_facture'));
    }

    public function payBill(Request $request)
    {
        if ($request->get('montant') <= 0) {
            return back()->with('error', 'Imposible de régler une facture vide!');
        } else {
            $facture = Facture::create([
                'numero' => $request->get('numero'),
                'structure_id' => $request->get('structure_id'),
                'nombre_message' => $request->get('nombre_messages'),
                'destinataires' => $request->get('destinataires'),
                'montant' => $request->get('montant')
            ]);
    
            $all_messages = explode('-', $request->get('messages'));
    
            for ($i = 0; $i < sizeof($all_messages); $i++) {
                DB::insert('insert into completions (facture_id, message_id) values (?, ?)', [$facture->id, $all_messages[$i]]);
                DB::update('update messages set paid = 1 where id = ?', [$all_messages[$i]]);
            }
    
            return redirect()->route('admin.facture_index');
        }
    }

    public function index()
    {
        $page = 'factures';
        $factures = Facture::orderByDesc('id')->with('structure')->get();
        return view('admin.facture.index', compact('page', 'factures'));
    }

    public function show(Facture $facture)
    {
        $page = 'factures';
        $statistiques = DB::table('completions')
            ->join('factures', 'completions.facture_id', '=', 'factures.id')
            ->join('messages', 'completions.message_id', '=', 'messages.id')
            ->select('messages.*')
            ->where('factures.numero', '=', $facture->numero)
            ->get();
        return view('admin.facture.show', compact('facture', 'page', 'statistiques'));
    }
}
