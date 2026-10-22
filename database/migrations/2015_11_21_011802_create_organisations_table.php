<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->increments('id_organisation');
            $table->integer('id_usager');
            $table->string('nom', 100);
            $table->string('lien_description');
            $table->integer('nombre_license');
            $table->string('nom_contact', 100);
            $table->string('prenom_contact', 100);
            $table->string('courriel', 100);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('organisations');
    }
}
