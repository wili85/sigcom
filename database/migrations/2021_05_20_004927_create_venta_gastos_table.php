<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta_gastos', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('id_venta')->nullable()->unsigned();
            $table->foreign('id_venta')->references('id')->on('ventas');
			$table->integer('id_producto')->nullable()->unsigned();
            $table->foreign('id_producto')->references('id')->on('productos');
			$table->integer('id_unidad')->nullable()->unsigned();
            $table->foreign('id_unidad')->references('id')->on('tabla_maestras');
			$table->double('cantidad',15,8)->nullable();
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
        Schema::dropIfExists('venta_gastos');
    }
}
