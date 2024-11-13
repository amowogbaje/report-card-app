<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username');
            // $table->tinyInteger('active')->default(1);
            $table->integer('school_info_id')->nullable();
            $table->string('othernames')->nullable();
            // $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->enum('role', ['admin', 'student', 'teacher']);
            $table->string('password');
            $table->string('dob')->nullable();
            $table->string('profile_pics')->nullable();
            $table->string('signature_url')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('state_origin')->nullable();
            $table->string('lga_origin')->nullable();
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
        Schema::dropIfExists('users');
    }
}
