<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no');
            $table->string('amount');
            $table->integer('student_id');
            // $table->integer('user_id');
            $table->string('student_account_name')->nullable();
            $table->integer('payment_detail_id')->nullable();
            $table->integer('session_id');
            $table->integer('term_id');
            $table->string('payment_method');
            $table->string('proof_url');
            $table->enum('status', ['pending', 'approved', 'dismissed'])->default('pending');
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
        Schema::dropIfExists('transactions');
    }
}
