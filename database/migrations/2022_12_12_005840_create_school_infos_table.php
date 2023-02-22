<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('codename');
            $table->string('address');
            $table->tinyInteger('setup_complete')->default(0);
            $table->enum('type', ['preparatory', 'secondary']);
            $table->string('stamp_img_url')->nullable();
            $table->json('school_colors')->nullable();
            // $table->enum('type', ['primary', 'junior secondary', 'senior secondary']);
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
        Schema::dropIfExists('school_infos');
    }
}
