<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCondominios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::defaultStringLength(191);
        Schema::create('usuarios_condominios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('condominio_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->boolean('seleccionado')->default(false);
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
        Schema::dropIfExists('usuarios_condominios');
    }
}
