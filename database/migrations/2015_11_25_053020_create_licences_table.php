<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licences', function (Blueprint $table) {
            $table->increments('id_licence');
            $table->integer('id_usager')->unsigned();
            $table->integer('id_type_licence');
            $table->string('nom', 100);
            $table->string('lien_description');
            $table->integer('nombre_licence');
            $table->date('date_achat_licence');
            $table->date('date_expiration_licence');
            $table->string('nom_contact', 100);
            $table->string('prenom_contact', 100);
            $table->string('courriel', 100);
            $table->timestamps();

            /*$table->foreign('id_usager')
                  ->references('id_licence')
                  ->on('users')
                  ->onDelete('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('licences');
    }
}
