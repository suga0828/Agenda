<?php

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

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

//ejemplo como trabajar ruta y escribir en log
Route::get('test', function () {
    \Log::info('aqui escribiendo por consola');
});

//un resource a diferencias de las rutas convencionales 
//crea una ruta de cada metodo que se encuentra en el controlador 
//Route::resource('contacts', 'Contacts');

//vista de crear contacto

Route::group(['middleware' => 'auth'], function () {
    Route::get('contacts/create',['as'=>"contacts.create",'uses'=>'Contacts@create']);
    Route::post('contacts',["as"=>'contacts.store','uses'=>'Contacts@store']);
    Route::put('contacts/{id}',['as'=>'contacts.update','uses'=>'Contacts@update'])->where('id','^[0-9]+$');
    Route::delete('contacts/{id}',['as'=>'contacts.destroy','uses'=>'Contacts@destroy']);
});


 Route::get('contacts/{id}/edit',["as"=>"contacts.edit","uses"=>"Contacts@edit"])->where('id','^[0-9]+$')->middleware('auth','welcome');



Route::get('welcome',function (){
    Mail::send('emails.message',['name'=>'Alexander'],function (Message $message){
        $message->to('alexander.sf0828@hotmail.com','Alexander')
        ->from('alexnder.sf0828@gmail.com','Alexander Sandoval')
        ->subject('Hola');
    });
});

