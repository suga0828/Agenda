<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Contact;
use Storage;
use Session;
use Illuminate\Support\Facades\Mail;
use \App\Mail\CreateContacts;

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
        $arrData=array(
            'name'=>'',
            'email'=>'',
            'file'=>'',
            'id'=>'',
            'title'=>'Crear Contacto',
            'route'=>'contacts'
        );
        Session::forget('msj');
        Session::forget('nomsj');
        return view('contacts.create')->with('contact',$arrData);
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

    public function saveImg($img){
        $name_file=ltrim(time().'_'.$img->getClientOriginalName());
        if(\Storage::disk('imgContacts')->put($name_file,\File::get($img))){
            return $name_file;
        }else{
            false;
        }
    }

    public function sendMail($request){
        $data=$request->all();
        if(Mail::to($data["email"],$data["name"])->send(new CreateContacts($data))){
            return true;
        }else{
            return false;
        }
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
            // 'contactfile'=>'required'
        ]);
        $user=\Auth::user();
        $contacts= new \App\Contact();
        $contacts->name=$request->name;
        $contacts->email=$request->email;

        if(!empty($request->contactfile)){
            $img=$request->contactfile;
            $nameFile=$this->saveImg($img);
            if($nameFile!=false){
                $contacts->file=$nameFile;
            }
        }
        
        $enviar=false;
        if($user->contacts()->save($contacts)->save()){
            $enviar=($this->sendMail($request))?true:false;
            //variable de session
            if($enviar){
                return back()->with('msj','Datos guardados con exito');
            }else{
                return back()->with('nomsj','Error enviando el email');
            }
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
        $ojContact= new \App\Contact();
        $data=$ojContact::find($id);
        $arrData=array(
            'name'=>$data->name,
            'email'=>$data->email,
            'file'=>$data->file,
            'id'=>$data->id,
            'title'=>'Editar Contacto',
            'route'=>'contacts/'.$data->id
        );
        Session::forget('msj');
        Session::forget('nomsj');
        return view('contacts.create')->with(['contact'=>$arrData]);

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
        $objContact= new \App\Contact();
        $data=$objContact::find($id);
        $data->email=$request->email;
        $data->name=$request->name;

        if(!empty($request->contactfile)){
            if(!empty($data->file)){
                //borrar imagen
                $delete=$this->deleteImg($id);
                if($delete==false){
                    return back()->with('nomsj','Error no se elimino la imagen');
                }
            }
            //guardar imagen
            $nameImg=$this->saveImg($request->contactfile);
            if($nameImg!=false){
                $data->file=$nameImg;
            }
        }

        if($data->save()){

            $arrData=array(
            'name'=>$data->name,
            'email'=>$data->email,
            'file'=>$data->file,
            'id'=>$data->id,
            'title'=>'Editar Contacto',
            'route'=>'contacts/'.$data->id
           );

           return view('contacts.create')->with(['contact'=>$arrData]); 
            //return \App::abort(404);
            //return view('errors.503');

        }else{

            return view('errors.503');
            //return \App::abort(404);
        }


    }

    public function deleteImg($id){
        $contact= new \App\Contact();
        $datacontact=$contact->find($id);
        $nomfile=$datacontact->file;
        $delete=Storage::disk('imgContacts')->delete($nomfile);
        if($delete){
            $datacontact->file=null;
            return $datacontact->save();
        }else{
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objContact= new Contact();
        $objContact=$objContact::find($id);
        if($objContact->delete()){
            Session::flash('msj','Eliminado con exito');
            return redirect('home');
        }else{
            Session::flash('nomsj','Error al eliinar');
            return redirect('home');
        } 
    }
}
