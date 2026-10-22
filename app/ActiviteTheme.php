<?php

namespace App;

Use Illuminate\Database\Eloquent\Model;


class ActiviteTheme extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activites_themes';
    protected $primaryKey = 'ID_THEMES';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

}
