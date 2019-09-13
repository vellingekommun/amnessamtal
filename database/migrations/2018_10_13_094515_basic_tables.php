<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BasicTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('room');
            $table->integer('event_id')->unsigned();
        });

        Schema::create('grade_teacher', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grade_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('event_id')->unsigned();
        });

        Schema::create('visitors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('student_name');
            $table->string('verification_code');
            $table->string('token');
            $table->integer('grade_id')->unsigned();
            $table->integer('event_id')->unsigned();
        });

        Schema::create('slots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('teacher_id');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('reserved_at')->nullable();
            $table->integer('visitor_id')->nullable();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('class_teacher');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('visitors');
        Schema::dropIfExists('slots');
        Schema::dropIfExists('events');
    }
}
