<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;use Illuminate\Notifications\Notifiable;

class User extends Authenticatable{    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'id_usager';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'id_type_usager', 'id_licence'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


}
