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
        Schema::create('pagopar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->integer('payed');
            $table->string('payment_method');
            $table->date('payment_date');
            $table->string('amount');
            $table->date('maximum_payment_date');
            $table->string('order_hash');
            $table->bigInteger('order_number');
            $table->string('cancelled');
            $table->string('payment_method_identifier');
            $table->string('token');
            $table->string('payment_result_message');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagopar');
    }
};
