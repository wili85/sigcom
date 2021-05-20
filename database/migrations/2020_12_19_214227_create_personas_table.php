<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('tipo_documento', ['DNI', 'CARNET_EXTRANJERIA', 'PASAPORTE'])->nullable();
            $table->string('numero_documento')->nullable()->index();
            $table->string('nombres');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['F', 'M']);
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('personas');
    }
}
