<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStateIdToTelefonosTable extends Migration
{
    public function up()
    {
        Schema::table('telefonos', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id')->after('city_id');
            $table->foreign('state_id');
        });
    }

    public function down()
    {
        Schema::table('telefonos', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');
        });
    }
}
