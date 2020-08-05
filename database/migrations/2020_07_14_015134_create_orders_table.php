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
            $table->id();
            $table->timestamps();
            $table->timestamp('reservation_time', 0)->nullable();
            $table->timestamp('expiration_time', 0)->nullable();
            $table->tinyInteger('status')->default(2); // 0 - deleted, 1 - completed, 2 - in progress
            $table->foreignId('user_id')->constrained();
            $table->foreignId('table_id')->constrained();
            $table->foreignId('restaurant_id')->constrained();
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
