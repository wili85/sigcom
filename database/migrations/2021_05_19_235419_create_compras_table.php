<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->date('fecha')->nullable();
			$table->integer('id_persona')->nullable()->unsigned();
            $table->foreign('id_persona')->references('id')->on('personas');
			$table->integer('id_empresa')->nullable()->unsigned();
            $table->foreign('id_empresa')->references('id')->on('empresas');
			$table->double('total',15,8)->nullable();
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
        Schema::dropIfExists('compras');
    }
}
