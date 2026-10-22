<?php

namespace App;

Use Illuminate\Database\Eloquent\Model;


class Resultat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'resultats';
    protected $primaryKey = 'id_resultat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

}
