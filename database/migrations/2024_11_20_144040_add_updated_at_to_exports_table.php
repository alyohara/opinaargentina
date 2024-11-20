<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedAtToExportsTable extends Migration
{
    public function up()
    {
        Schema::table('exports', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('exports', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
    }
}
