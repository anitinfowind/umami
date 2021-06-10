<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('restaurant_id');
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->integer('diet_id');
            $table->integer('region_id');
            $table->string('title');
            $table->string('slug');
            $table->integer('price');
            $table->integer('discount')->nullable();
            $table->integer('quantity');
            $table->integer('remaining_quantity');
            $table->enum('shipping_type',['FREE','PAID'])->default('FREE');
            $table->integer('shipping_price')->nullable();
            $table->text('description');
            $table->string('attribute');
            $table->enum('editor_pick',['0','1'])->default('0');
            $table->text('ingredients');
            $table->text('nutrition');
            $table->text('details');
            $table->string('video');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
