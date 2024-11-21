<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToExportsTable extends Migration
{
    public function up()
    {
        Schema::table('exports', function (Blueprint $table) {
            $table->integer('file_size')->nullable();
            $table->timestamp('job_started_at')->nullable();
            $table->timestamp('job_ended_at')->nullable();
            $table->string('status')->default('fail');
        });
    }

    public function down()
    {
        Schema::table('exports', function (Blueprint $table) {
            $table->dropColumn(['file_size', 'job_started_at', 'job_ended_at', 'status']);
        });
    }
}
