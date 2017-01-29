<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Storage;

class Contacts extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('aqui');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //parametro inyeccion de servicios 
    //que enlaza las reglas de la clase request que declaramos 
    //para validar el formulario antes que entre al controlador
    /*public function store(\App\Http\Requests\Contacts $request)
    {
        dd($request->name);
    }*/

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
            'contactfile'=>'required'
        ]);
        $user=\Auth::user();
        $contacts= new \App\Contact();
        $contacts->name=$request->name;
        $contacts->email=$request->email;
        $img=$request->contactfile;
        $name_file=ltrim(time().'_'.$img->getClientOriginalName());
        Storage::disk('imgContacts')->put($name_file,file_get_contents($img->getRealPath()));
        $contacts->file=$name_file;
        if($user->contacts()->save($contacts)->save()){
            //variable de session 
            return back()->with('msj','Datos guardados con exito');
        }else{
            return back()->with('nomsj','Error en la base de datos');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
