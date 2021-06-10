<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ColoumChangeAttributeToAttributeIdProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function($table) {
            $table->dropColumn('attribute');
        });
		
		Schema::table('products', function (Blueprint $table) {
            $table->string('attribute_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('products', function($table) {
            $table->dropColumn('attribute_id');
        });
		
		Schema::table('products', function (Blueprint $table) {
            $table->string('attribute')->nullable();
        });
    }
}
