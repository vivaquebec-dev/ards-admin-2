<?php

namespace App;

Use Illuminate\Database\Eloquent\Model;


class Eleve extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'eleves';
    protected $primaryKey = 'id_eleve';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'id_usager',
        'sexe'
    ];



}

