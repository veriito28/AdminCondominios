<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('condominio_id')->unsigned()->nullable();
            $table->string('encabezado')->nullable();
            $table->string('mensaje')->nullable();
            $table->decimal('prosupuestado_atrazado',14,2)->default(0)->nullable();
            $table->decimal('diferencia_autorizada',14,2)->default(0)->nullable();
            $table->date('fecha');
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
        Schema::dropIfExists('reportes');
    }
}
