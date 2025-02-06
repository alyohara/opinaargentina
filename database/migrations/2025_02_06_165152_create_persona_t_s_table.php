<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas_t', function (Blueprint $table) {
            $table->increments('id');
            $table->string('apellido_y_nombre', 255)->nullable();
            $table->integer('dni')->nullable();
            $table->string('direccion', 255)->nullable();
            $table->integer('anio_nacimiento')->nullable();
            $table->text('genero')->nullable();
            $table->string('nacionalidad', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('dato_extra_1')->nullable();
            $table->text('dato_extra_2')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('movil', 20)->nullable();
            $table->integer('cp')->nullable();
            $table->string('seccion', 50)->nullable();
            $table->string('circuito', 50)->nullable();
            $table->integer('mesa')->nullable();
            $table->integer('orden')->nullable();
            $table->string('establecimiento', 255)->nullable();
            $table->string('direccion_establecimiento', 255)->nullable();
            $table->string('state', 50)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->integer('localidad_id')->nullable();

            // Índices
            $table->index('dni', 'idx_dni');
            $table->index('localidad_id', 'idx_localidad_id');
            $table->index('movil', 'idx_movil');
            $table->index('telefono', 'idx_telefono');

            // Si deseas utilizar los timestamps automáticos de Laravel, podrías omitir las columnas creadas_at, updated_at, deleted_at.
            // $table->timestamps();
            // Para soft deletes: $table->softDeletes();
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas_t');
    }
}
