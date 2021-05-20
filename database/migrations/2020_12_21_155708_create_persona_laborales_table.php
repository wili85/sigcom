<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaLaboralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona_laborales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_persona')->nullable()->unsigned();
            $table->foreign('id_persona')->references('id')->on('personas');
			$table->integer('id_tipo')->nullable()->unsigned();
			$table->string('id_establo',100)->nullable();
            $table->string('id_area',100)->nullable();
            $table->string('id_cargo',100)->nullable();
            $table->enum('estado', ['A', 'C']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona_laborales');
    }
}
