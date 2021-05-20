<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVehiculos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_empresa')->unsigned()->index();
			$table->foreign('id_empresa')->references('id')->on('empresas');
			$table->bigInteger('id_tipo_vehiculo')->unsigned()->index();
			$table->foreign('id_tipo_vehiculo')->references('id')->on('tabla_maestras');
			$table->string('placa',10)->nullable()->index();
            $table->integer('ejes')->nullable()->default(2);
			$table->integer('peso_seco')->nullable();
			$table->string('estado',1)->nullable()->default('1');
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
        Schema::dropIfExists('vehiculos');
    }
}
