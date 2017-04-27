<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('concepto')->nullable();
            $table->decimal('cantidad',14,2)->default(0)->nullable();
            $table->date('fecha');
            $table->char('tipo', 1)->defualt('P');
            $table->integer('condominio_id')->unsigned()->nullable();
            $table->integer('casa_id')->unsigned()->nullable();
            $table->integer('adeudo_id')->unsigned()->nullable();
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
        Schema::dropIfExists('pagos');
    }
}
