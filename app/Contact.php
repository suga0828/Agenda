<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'email', 'name',
    ];

    //relacion de pertenencia 
    //un usuario puede tener muchos contactos
    public function user(){
        return $this->belongsTo('App\User');
    }



}
