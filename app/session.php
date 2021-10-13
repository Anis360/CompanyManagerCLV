<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class session extends Model
{
    protected $table = 'sessions';
    protected $fillable = ['Theme_session','Date_debut','Date_fin','Nom_Formateur1','Nom_Formateur2','Nom_SF','Etat','Commentaire'];
}