<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('class_id');
            $table->string('guardian_name')->nullable();
            $table->string('guardian_address')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('student_phone')->nullable();
            $table->string('class_matric_no')->nullable();
            $table->string('class_code')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('payment_complete')->default(0);
            $table->string('payment_progress')->nullable();
            $table->string('wallet_amount')->default(0);
            $table->string('class_stage_id')->default(0);
            $table->enum('category', [null, 'art', 'science', 'commercial'])->nullable();
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
        Schema::dropIfExists('students');
    }
}
