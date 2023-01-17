<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherSubjectClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_subject_classes', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id');
            $table->integer('subject_id');
            $table->integer('class_id');
            $table->integer('session_id');
            $table->integer('term_id');
            $table->integer('periods')->default(0);
            // $table->enum('category', [null, 'art', 'science', 'commercial'])->nullable();
            $table->tinyInteger('result_uploaded')->default(0);
            // $table->tinyInteger('student_result_processed')->default(0);
            $table->tinyInteger('class_result_processed')->default(0);

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
        Schema::dropIfExists('teacher_subject_classes');
    }
}
