<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChoferesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('choferes', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('id_vehiculo')->unsigned()->index();
			$table->foreign('id_vehiculo')->references('id')->on('vehiculos');
            $table->bigInteger('id_persona')->unsigned()->index();
			$table->text('nro_brevete');
            $table->text('observaciones');
            $table->enum('sexo', ['F', 'M']);
			$table->string('estado',1)->default('1');
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
        Schema::dropIfExists('choferes');
    }
}
