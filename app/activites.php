<?php

namespace App;

Use Illuminate\Database\Eloquent\Model;


class activites extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activites';
    protected $primaryKey = 'ID_ACTIVITES';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PREFIXE_ACTIVITES',
        'NOM_ACTIVITES'
    ];

}
