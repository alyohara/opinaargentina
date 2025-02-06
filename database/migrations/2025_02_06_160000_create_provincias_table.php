<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvinciasTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provincias', function (Blueprint $table) {
            // Campo auto incremental y clave primaria
            $table->increments('id');

            // Campo 'nombre' de 100 caracteres, permite null y debe ser único
            $table->string('nombre', 100)->nullable()->unique();

            // Opcional: crear índices explícitos (aunque la clave primaria 'id' ya está indexada)
            $table->index('id', 'idx_id_provincia');
            $table->index('nombre', 'idx_nombre_provincia');

            // Si lo deseas, puedes agregar timestamps
            // $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provincias');
    }
}
