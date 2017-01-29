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
Route::resource('contacts', 'Contacts');
