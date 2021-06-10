<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
			$table->integer('product_id');
			$table->integer('country_id')->nullable();
			$table->integer('state_id')->nullable();
			$table->integer('city_id')->nullable();
			$table->string('order_id')->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->text('street_address')->nullable();
			$table->text('alternative_address')->nullable();
			$table->string('zip_code')->nullable();
			$table->enum('payment_type',['CASH_ON_DELIVERY','ONLINE'])->default('CASH_ON_DELIVERY');
			$table->enum('status',['PENDING','PACKED','SHIPPED','DELIVERED','CANCELLED'])->default('PENDING');
			$table->enum('is_gift',['ACTIVE','INACTIVE'])->default('INACTIVE');
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
        Schema::dropIfExists('orders');
    }
}
