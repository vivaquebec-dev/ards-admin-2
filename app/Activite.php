<?php

namespace App;

Use Illuminate\Database\Eloquent\Model;


class Activite extends Model
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

    ];

}
