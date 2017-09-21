<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptoAdeudosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepto_adeudos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('slug_nombre');
            $table->char('tipo')->defualt('M');
            $table->char('deudor')->defualt('G');
            $table->integer('condominio_id')->unsigned()->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('concepto_adeudos');
    }
}
