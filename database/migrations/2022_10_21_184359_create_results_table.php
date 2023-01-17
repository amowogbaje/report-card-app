<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_id');
            $table->integer('student_id');
            $table->integer('term_id');
            $table->integer('session_id');
            $table->integer('class_id');
            $table->string('ca_1')->default(0);
            $table->string('ca_2')->default(0);
            $table->string('ca_3')->default(0);
            $table->string('totalca')->default(0);
            $table->string('exam')->default(0);
            $table->string('total_score')->default(0);
            $table->string('cumulative_percentage')->nullable();
            $table->string('highest_score')->nullable();
            $table->string('lowest_score')->nullable();
            $table->string('average_score')->nullable();
            $table->string('grade')->nullable();
            $table->string('position')->nullable();
            $table->tinyInteger('percentage_computed')->default(0);
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
        Schema::dropIfExists('results');
    }
}
