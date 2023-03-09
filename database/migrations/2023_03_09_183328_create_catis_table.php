<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('img')->nullable();
            $table->string('descripcion');
            $table->boolean('visible')->nullable();
            $table->unsignedBigInteger('prioridad')->nullable()->index('prioridad');
            $table->string('asunto', 100)->nullable();
            $table->string('acciones_corr')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable()->index('usuario_id');
            $table->unsignedBigInteger('atendio_id')->nullable()->index('atendio_id');
            $table->unsignedBigInteger('usuario_asign_id')->nullable()->index('usuario_asign_id');
            $table->unsignedBigInteger('rendimiento_id')->nullable()->index('rendimiento_id');
            $table->unsignedBigInteger('categoria_id')->nullable()->index('categoria_id');
            $table->unsignedBigInteger('incidencia_id')->nullable()->index('incidencia_id');
            $table->unsignedBigInteger('tipo_id')->nullable()->index('tipo_id');
            $table->unsignedBigInteger('status_id')->nullable()->index('status_id');
            $table->unsignedBigInteger('hardware_id');
            $table->unsignedBigInteger('div_equipo_id')->nullable();
            $table->timestamp('close_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catis');
    }
}
