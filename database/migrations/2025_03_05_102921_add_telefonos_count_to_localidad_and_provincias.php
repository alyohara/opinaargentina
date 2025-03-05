<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTelefonosCountToLocalidadAndProvincias extends Migration
{
    public function up()
    {
        Schema::table('localidades', function (Blueprint $table) {
            $table->integer('telefonos_count')->default(0);
        });

        Schema::table('provincias', function (Blueprint $table) {
            $table->integer('telefonos_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('localidades', function (Blueprint $table) {
            $table->dropColumn('telefonos_count');
        });

        Schema::table('provincias', function (Blueprint $table) {
            $table->dropColumn('telefonos_count');
        });
    }
}
