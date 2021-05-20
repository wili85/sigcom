<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('id_compra')->nullable()->unsigned();
            $table->foreign('id_compra')->references('id')->on('compras');
			$table->date('fecha')->nullable();
			$table->integer('id_forma_pago')->nullable()->unsigned();
            $table->foreign('id_forma_pago')->references('id')->on('tabla_maestras');
			$table->double('importe',15,8)->nullable();
			$table->string('numero_operacion',50)->nullable();
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
        Schema::dropIfExists('compra_pagos');
    }
}
