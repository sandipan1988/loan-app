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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->unsignedBigInteger('loan_id');
            $table->date('installment_date');
            $table->double('installment_amount');
            $table->enum('is_paid', ['YES', 'NO'])->default('NO');
            $table->date('paid_date')->nullable();
            $table->timestamps();
            $table->foreign('loan_id')->references('loan_id')->on('loans')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
