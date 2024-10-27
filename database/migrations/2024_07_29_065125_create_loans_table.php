<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id('loan_id');
            $table->text('loan_account')->unique();
            $table->unsignedBigInteger('member_id');
            $table->enum('loan_type', ['1', '2','3']);
            $table->double('interest_rate');
            $table->double('loan_amount');
            $table->double('installment_amount');
            $table->date('loan_start_date');
            $table->date('loan_end_date')->nullable();
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
        Schema::dropIfExists('loans');
    }
};
