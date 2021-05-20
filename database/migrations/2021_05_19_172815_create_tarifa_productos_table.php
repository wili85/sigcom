<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifaProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifa_productos', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('id_producto')->nullable()->unsigned();
			$table->foreign('id_producto')->references('id')->on('productos');
			$table->integer('id_tarifa')->nullable()->unsigned();
			$table->foreign('id_tarifa')->references('id')->on('tarifas');
			$table->double('precio',15,8)->nullable();
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
        Schema::dropIfExists('tarifa_productos');
    }
}
