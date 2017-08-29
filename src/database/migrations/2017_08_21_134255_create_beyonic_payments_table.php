<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeyonicPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beyonic_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('billable');
            $table->string('transaction_id')->unique();
            $table->dateTime('initiated_at');
            $table->boolean('approved')->default(0);
            $table->string('amount');
            $table->string('phone_number');
            $table->text('reason');
            $table->text('payment_details')->nullable();
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
        Schema::dropIfExists('beyonic_payments');
    }
}
