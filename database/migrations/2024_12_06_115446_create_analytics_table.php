<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyticsTable extends Migration
{
    public function up()
    {
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->integer('total_telefonos');
            $table->integer('total_usuarios');
            $table->json('telefonos_por_provincia');
            $table->json('usuarios_por_rol');
            $table->string('localidad_con_mas_telefonos');
            $table->json('ranking_provincias');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('analytics');
    }
}
