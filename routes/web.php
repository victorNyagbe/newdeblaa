<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',  function() {
    if (session()->has('category')) {
        if (session()->get('category') == 'structure') {
            return redirect()->route('structure.index');
        }
    } else {
        return view('visitors.index');
    }
})->name('main.home');

Route::get('structure', 'StructureController@index')->name('structure.index');

Route::get('structure/contacts-message', 'StructureController@createContact')->name('structure.createContact');

Route::get('login', 'StructureController@loginForm')->name('structure.loginForm');

Route::post('login', 'StructureController@login')->name('structure.login');

Route::get('deconnexion', 'StructureController@logout')->name('structure.logout');

Route::get('profil', 'StructureController@show_profile')->name('structure.showProfile');

Route::patch('profil/{structure}', 'StructureController@update_profile')->name('structure.updateProfile');

Route::patch('change-password/{structure}', 'StructureController@changePassword')->name('structure.changePassword');

Route::get('/message', 'StructureController@message')->name('structure.message');

Route::post('/message-store', 'MessageController@store')->name('message.store');

Route::get('/messages/bilan', 'StructureController@bilan')->name('messages.bilan');

Route::post('/nouveau_message', 'StructureController@renvoyer_message')->name('renvoyer.message');

Route::get('/voir-message/{message_id}', 'StructureController@show_bilan')->name('messages.showBilan');

Route::post('/default-messages', 'MessageController@storeDefaultMessage')->name('storeDefaultMessage');

Route::delete('destroy-message/{defaultMessage}', 'StructureController@destroyDefaultMessage')->name('destroyDefaultMessage');

Route::get('/contacts', 'ContactController@index')->name('contacts.index');

Route::post('/contacts-store', 'ContactController@store')->name('contacts.store');

Route::delete('/contact/{contact}/delete', 'ContactController@destroy')->name('contact.delete');

//Route::get('statistique', 'StructureController@index_stat')->name('structure.statistique');

//Route::get('mes-factures', 'StructureController@factures_index')->name('structure.factureIndex');

//Route::get('mes-factures/{facture}', 'StructureController@facture_show')->name('structure.factureShow');

Route::get('mon-ticket/sms', 'StructureController@ticket')->name('structure.ticket');

Route::post('mon-ticket/validation-processing', 'StructureController@valider_ticket')->name('structure.validerTicket');

Route::get('contacts', 'ContactController@contact')->name('structure.contact');

Route::post('storepermanentcontact', 'ContactController@contact_permanent')->name('structure.storePermanentContact');

Route::get('modfier-contact/{contact}', 'ContactController@editContactPermanent')->name('structure.editContactPermanent');

Route::patch('modfier-contact/{contact}/updateProcessing', 'ContactController@updateContactPermanent')->name('structure.updateContactPermanentProcessing');

Route::get('supprimer-contact/{contact}/destroyProcessing', 'ContactController@destroyPermanentContact')->name('structure.destroyContactPermanentProcessing');

Route::post('contactsLinkToMessage', 'ContactController@contactPermanentLinkToMessage')->name('structure.contactPermanentLinkToMessage');

Route::get('mes-groupes', 'GroupController@index')->name('groups.index');

Route::get('mes-groupes/{group}', 'GroupController@show')->name('groups.show');

Route::get('mes-groupes/{group}/Modifier', 'GroupController@edit')->name('groups.edit');

Route::patch('mes-groupes/{group}/editProcessing', 'GroupController@update')->name('groups.update');

Route::get('mes-groupes/{group}/deleteProcessing', 'GroupController@destroy')->name('groups.delete');

Route::post('store-group', 'GroupController@store')->name('groups.store');

Route::get('mes-groupes/{group}/ajouter-contact', 'GroupController@addContactView')->name('groups.addContactView');

Route::post('storeContactProcessing/{group}', 'GroupController@addContactToGroup')->name('groups.storeContactProcessing');

Route::post('storeContactByListOfContactProcessing/{group}', 'GroupController@addListOfContactToGroup')->name('groups.storeContactByListOfContactProcessing');

Route::post('sendMessageByGroupProcessing', 'GroupController@sendMessageByIndividualGroup')->name('structure.sendMessageByGroupProcessing');

Route::post('sendMessageByAllGroupProcessing', 'GroupController@sendMessageByGroups')->name('structure.sendMessageByAllGroupProcessing');

/*Administration's routes*/

Route::prefix('admin')->group(function () {
    Route::get('login', 'Admin\LoginController@loginForm')->name('admin.loginForm');

    Route::post('login-processing', 'Admin\LoginController@login')->name('admin.login');

    Route::get('register', 'Admin\RegisterController@registrationForm')->name('admin.registrationForm');

    Route::post('registration-processing', 'Admin\RegisterController@register')->name('admin.register');

    Route::get('', 'Admin\AdminController@home')->name('admin.home');

    Route::get('structures', 'Admin\AdminController@structure')->name('admin.structures');

    Route::get('structure/{structure}', 'Admin\StructureController@show')->name('admin.structureShow');
    
    Route::delete('structure/{structure}/deleteProcessing', 'Admin\StructureController@destroy')->name('admin.structureDestroy');

    Route::post('register-structure', 'Admin\AdminController@registerStructure')->name('admin.registerStructure');

    Route::get('statistiques', 'Admin\FactureController@statistique')->name('admin.statistique');

    Route::get('statistique/{structure}', 'Admin\FactureController@statistique_show')->name('admin.statistiqueShow');

    Route::post('reglement-facture', 'Admin\FactureController@payBill')->name('admin.payBill');

    Route::get('factures', 'Admin\FactureController@index')->name('admin.facture_index');

    Route::get('facture/{facture}', 'Admin\FactureController@show')->name('admin.facture_show');

    Route::get('categories-tickets', 'Admin\CategorieTicketController@index')->name('admin.categorieTicketIndex');

    Route::post('categories-tickets/store', 'Admin\CategorieTicketController@store')->name('admin.categorieTicketStore');

    Route::delete('categories-tickets/{categorieTicket}/delete', 'Admin\CategorieTicketController@destroy')->name('admin.categorieTicketDelete');

    Route::get('tickets', 'Admin\TicketController@index')->name('admin.ticketIndex');

    Route::get('ticket/perso', 'Admin\TicketController@persoIndex')->name('admin.ticketPerso');

    Route::get('ticket/pro', 'Admin\TicketController@proIndex')->name('admin.ticketPro');

    Route::get('ticket/promax', 'Admin\TicketController@proMaxIndex')->name('admin.ticketPromax');

    Route::post('ticket/storeTicketPerso', 'Admin\TicketController@storePerso')->name('admin.storePerso');

    Route::post('ticket/storeTicketPro', 'Admin\TicketController@storePro')->name('admin.storePro');

    Route::post('ticket/storeTicketPromax', 'Admin\TicketController@storePromax')->name('admin.storePromax');

    Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');
});
