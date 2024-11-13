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
            $table->integer('class_id')->nullable();
            $table->integer('class_code')->nullable();
            $table->integer('ca_1')->default(0);
            $table->integer('ca_2')->default(0);
            $table->integer('ca_3')->default(0);
            $table->integer('totalca')->default(0);
            $table->integer('exam')->default(0);
            $table->integer('total_score')->nullable();
            $table->integer('cumulative_percentage')->nullable();
            $table->integer('highest_score')->nullable();
            $table->integer('lowest_score')->nullable();
            $table->integer('average_score')->nullable();
            $table->integer('grade')->nullable();
            $table->integer('position')->nullable();
            $table->integer('percentage_computed')->default(0);
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
