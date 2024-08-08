<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('name');
            $table->integer('quantity');
            $table->bigInteger('category');
            $table->string('public_key');
            $table->string('url_imagen');
            $table->text('description');
            $table->float('unit_price',8,2);
            $table->string('seller_phone');
            $table->string('seller_address');
            $table->string('seller_ref');
            $table->string('seller_coords');
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
        Schema::dropIfExists('order_items');
    }
}
