<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            // Campo auto incremental como clave primaria
            $table->increments('id');

            // Campo 'nombre' de 100 caracteres, permite null
            $table->string('nombre', 100)->nullable();

            // Campo 'provincia_id' entero sin signo, no permite null
            $table->unsignedInteger('provincia_id');

            // Definición de la clave foránea: hace referencia al campo 'id' de la tabla 'provincias'
            $table->foreign('provincia_id')
                ->references('id')
                ->on('provincias')
                ->onDelete('cascade'); // Opcional: define comportamiento al eliminar una provincia

            // Índice en la columna 'nombre'
            $table->index('nombre', 'idx_nombre');

            // Índice en la columna 'provincia_id'
            $table->index('provincia_id', 'idx_provincia_id');

            // Si deseas agregar timestamps:
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
        Schema::dropIfExists('localidades');
    }
};

