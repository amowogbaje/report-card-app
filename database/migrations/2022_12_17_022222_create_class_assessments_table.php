<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_assessments', function (Blueprint $table) {
            $table->id();
            $table->integer('term_id');
            $table->integer('session_id');
            $table->integer('class_id');
            $table->string('highest_score');
            $table->string('lowest_score');
            $table->string('average_score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_assessments');
    }
}
