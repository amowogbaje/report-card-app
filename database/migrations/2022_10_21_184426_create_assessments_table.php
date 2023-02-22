<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->integer('school_info_id');
            $table->integer('session_id');
            $table->integer('term_id');
            $table->integer('student_id');
            $table->json('physical_assessments')->nullable();
            $table->json('skill_assessments')->nullable();
            $table->json('behavior_assessments')->nullable();
            $table->json('academic_assessments')->nullable();
            $table->string('student_attendance')->nullable();
            $table->string('overall_attendance')->nullable();
            $table->string('class_teacher_comment')->nullable();
            $table->string('principal_comment')->nullable();
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
        Schema::dropIfExists('assessments');
    }
}
