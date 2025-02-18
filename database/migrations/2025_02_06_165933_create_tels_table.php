<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tels', function (Blueprint $table) {
            $table->increments('id');

            // Definimos persona_id como entero sin signo, permitiendo null
            $table->unsignedInteger('persona_id')->nullable();

            // Definimos el enum para tipo_telefono con las opciones 'fijo' y 'movil'
            $table->enum('tipo_telefono', ['fijo', 'movil'])->nullable();

            // Número de teléfono con longitud máxima de 15 caracteres
            $table->string('nro_telefono', 15)->nullable();

            // Claves foráneas
            $table->unsignedInteger('localidad_id')->nullable();
            $table->unsignedInteger('provincia_id')->nullable();

            // Restricción única: combinación de persona_id, tipo_telefono y nro_telefono
            $table->unique(['persona_id', 'tipo_telefono', 'nro_telefono'], 'unique_telefono');

            // Definición de claves foráneas
            $table->foreign('persona_id')
                ->references('id')
                ->on('personas_t')
                ->onDelete('cascade'); // Ajusta la acción al eliminar según tus necesidades

            $table->foreign('localidad_id')
                ->references('id')
                ->on('localidades')
                ->onDelete('set null');

            $table->foreign('provincia_id')
                ->references('id')
                ->on('provincias')
                ->onDelete('set null');

            // Índices para optimizar las consultas
            $table->index('localidad_id', 'idx_localidad_id');
            $table->index('nro_telefono', 'idx_nro_telefono');
            $table->index('persona_id', 'idx_persona_id');
            $table->index('provincia_id', 'idx_provincia_id');
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tels');
    }
}
