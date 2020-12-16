<?php

namespace App\Http\Controllers\Admin;

use App\Cache;
use App\Group;
use App\Contact;
use App\Message;
use App\Structure;
use App\DefaultMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StructureController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    public function show(Structure $structure)
    {
        $page = 'structure';
        $contacts = Contact::where('structure_id', $structure->id)->get();
        $nombre_contactPermanent = Contact::where([
            ['permanent', 1],
            ['structure_id', $structure->id]
        ])->count();
        
        $nombre_contactNonPermanent = Contact::where([
            ['permanent', 0],
            ['structure_id', $structure->id]
        ])->count();
        return view('admin.structure.show', compact('structure', 'page', 'contacts', 'nombre_contactPermanent', 'nombre_contactNonPermanent'));
    }

    public function destroy(Structure $structure)
    {
        Message::where('structure_id', $structure->id)->delete();

        $groups = Group::where('structure_id', $structure->id)->get();

        Group::where('structure_id', $structure->id)->delete();

        DefaultMessage::where('structure_id', $structure->id)->delete();

        Contact::where('structure_id', $structure->id)->delete();

        if (count($groups) > 0)
        {
            foreach ($groups as $group)
            {
                DB::table('contact_group')->where('group_id', $group->id)->delete();
            }
        }
        Cache::where('structure_id', $structure->id)->delete();

        $structure->delete();

        return back()->with('success', 'La structure a été supprimée avec succès');
    }
}
