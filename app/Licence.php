<?php

namespace App;

Use Illuminate\Database\Eloquent\Model;


class Licence extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'licences';
    protected $primaryKey = 'id_licence';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'master_id_licence',
        'nom',
        'lien_description',
        'nombre_licence',
        'date_achat_licence',
        'date_expiration_licence',
        'nom_contact',
        'prenom_contact',
        'courriel'
    ];



}

