<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('description');
            $table->string('address');
            $table->string('phone')->default('');;
            $table->string('website')->default('');
            $table->string('image_path')->default('placeholder.png');;
            $table->foreignId('owner_id')->constrained('users');
            $table->boolean('deleted')->default(false); // WE DONT DELETE, WE SET AS CLOSED
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
