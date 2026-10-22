<?php



namespace App;



Use Illuminate\Database\Eloquent\Model;





class UserProgression extends Model

{

    /**

     * The database table used by the model.

     *

     * @var string

     */

	public $timestamps = false;
    protected $table = 'users_progression';

    protected $primaryKey = 'id_usager';



    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [



    ];



}

