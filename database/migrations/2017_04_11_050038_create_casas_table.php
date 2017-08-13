<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::defaultStringLength(191);
        Schema::create('casas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('condominio_id')->unsigned();
            $table->string('nombre');
            $table->string('no_cliente')->nullable();
            $table->string('manzana')->nullable();
            $table->string('interfon')->nullable();
            $table->string('lote')->nullable();
            $table->dateTime('fecha_esc')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('contacto')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casas');
    }
}
