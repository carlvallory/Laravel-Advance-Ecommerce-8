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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('phone');
            $table->string('ruc');
            $table->string('email');
            $table->bigInteger('city');
            $table->string('name');
            $table->bigInteger('phone');
            $table->string('dir');
            $table->bigInteger('ci');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('biz');
            $table->string('doc')->default('CI');
            $table->string('ref');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('buyers');
    }
};
