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

Route::get('login', 'StructureController@loginForm')->name('structure.loginForm');

Route::post('login', 'StructureController@login')->name('structure.login');

Route::get('deconnexion', 'StructureController@logout')->name('structure.logout');

Route::get('profil', 'StructureController@show_profile')->name('structure.showProfile');

Route::patch('profil/{structure}', 'StructureController@update_profile')->name('structure.updateProfile');

Route::patch('change-password/{structure}', 'StructureController@changePassword')->name('structure.changePassword');

Route::get('/message', 'StructureController@message')->name('structure.message');

Route::post('/message-store', 'MessageController@store')->name('message.store');

Route::get('/messages/bilan', 'StructureController@bilan')->name('messages.bilan');

Route::post('/default-messages', 'MessageController@storeDefaultMessage')->name('storeDefaultMessage');

Route::get('/contacts', 'ContactController@index')->name('contacts.index');

Route::post('/contacts-store', 'ContactController@store')->name('contacts.store');

Route::delete('/contact/{contact}/delete', 'ContactController@destroy')->name('contact.delete');

/*Administration's routes*/

Route::prefix('admin')->group(function () {
    Route::get('login', 'Admin\LoginController@loginForm')->name('admin.loginForm');

    Route::post('login-processing', 'Admin\LoginController@login')->name('admin.login');

    Route::get('register', 'Admin\RegisterController@registrationForm')->name('admin.registrationForm');

    Route::post('registration-processing', 'Admin\RegisterController@register')->name('admin.register');

    Route::get('', 'Admin\AdminController@home')->name('admin.home');

    Route::get('structures', 'Admin\AdminController@structure')->name('admin.structures');

    Route::post('register-structure', 'Admin\AdminController@registerStructure')->name('admin.registerStructure');

    Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');
});
