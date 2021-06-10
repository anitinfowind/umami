<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->enum('shipping_type',['PAID','FREE'])->default('FREE');
            $table->integer('price');
            $table->integer('discount')->nullable();
            $table->text('description');
            $table->text('more_detail');
            $table->text('shipping_detail');
            $table->enum('payment_type',['MONTHLY','ANNUALY'])->default('MONTHLY');
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
        Schema::dropIfExists('subscriptions');
    }
}
