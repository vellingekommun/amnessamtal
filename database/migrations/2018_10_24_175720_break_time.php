<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BreakTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('teachers', function (Blueprint $table) {
            $table->string('break_time')->nullable()->after("room");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('break_time');
        });
    }
}
