<?php

namespace App;

Use Illuminate\Database\Eloquent\Model;


class UserType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'type_usagers';
    protected $primaryKey = 'id_type_usagers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'est_actif'
    ];

}
