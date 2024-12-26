<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStateIdToTelefonosTable extends Migration
{
    public function up()
    {
        Schema::table('telefonos', function (Blueprint $table) {
            if (!Schema::hasColumn('telefonos', 'state_id')) {
                $table->unsignedBigInteger('state_id')->after('city_id');
            }
        });
    }

    public function down()
    {
        Schema::table('telefonos', function (Blueprint $table) {
            $table->dropColumn('state_id');
        });
    }
}
