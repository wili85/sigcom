<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('denominacion',100)->nullable();
			$table->integer('id_persona')->nullable()->unsigned();
			$table->foreign('id_persona')->references('id')->on('personas');
			$table->integer('id_empresa')->nullable()->unsigned();
			$table->foreign('id_empresa')->references('id')->on('empresas');
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
        Schema::dropIfExists('tarifas');
    }
}
