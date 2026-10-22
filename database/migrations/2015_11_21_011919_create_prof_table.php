<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prof', function (Blueprint $table) {
            $table->increments('id_etablissement');
            $table->integer('id_usager');
            $table->string('courriel', 100);
            $table->string('lien_description');
            $table->integer('nombre_license');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prof');
    }
}
