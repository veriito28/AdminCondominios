<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdeudosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adeudos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('concepto')->nullable();
            $table->decimal('cantidad',14,2)->defualt(0.0);
            $table->date('fecha');
            $table->char('tipo', 1)->defualt('M');
            $table->integer('condominio_id')->unsigned()->nullable();
            $table->integer('casa_id')->unsigned()->nullable();
            $table->integer('concepto_id')->unsigned()->nullable();
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
        Schema::dropIfExists('adeudos');
    }
}
