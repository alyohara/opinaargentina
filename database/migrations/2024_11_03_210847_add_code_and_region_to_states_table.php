<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeAndRegionToStatesTable extends Migration
{
    public function up()
    {
        Schema::table('states', function (Blueprint $table) {
            $table->string('code')->after('name');
            $table->string('region')->after('code');
        });
    }

    public function down()
    {
        Schema::table('states', function (Blueprint $table) {
            $table->dropColumn(['code', 'region']);
        });
    }
}
