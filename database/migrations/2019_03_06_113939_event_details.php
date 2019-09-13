<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('events', function (Blueprint $table) {
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('booking_starts_at')->nullable();
            $table->timestamp('booking_ends_at')->nullable();
            $table->text('booking_information')->nullable();
            $table->text('email_confirmation')->nullable();
            $table->text('sms_reminder')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('starts_at');
            $table->dropColumn('ends_at');
            $table->dropColumn('booking_starts_at');
            $table->dropColumn('booking_ends_at');
            $table->dropColumn('booking_information');
            $table->dropColumn('email_confirmation');
            $table->dropColumn('sms_reminder');
        });
    }
}
