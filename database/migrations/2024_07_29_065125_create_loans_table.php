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
            $table->string('name');
            $table->string('email')->nullable();
            $table->text('phone')->nullable();
            $table->text('loan_account')->unique();
            $table->string('address')->nullable();
            $table->enum('loan_type', ['1', '2','3']);
            $table->double('interest_rate');
            $table->double('loan_amount');
            $table->double('installment_amount');
            $table->date('loan_start_date');
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
