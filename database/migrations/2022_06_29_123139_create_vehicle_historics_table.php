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
        Schema::create('vehicle_historics', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('arrival_time')->nullable();
            $table->float('start_km')->nullable();
            $table->float('arrival_km')->nullable();
            $table->integer('amount_repaid')->nullable();
            $table->integer('ca_daily')->nullable();
            $table->string('travel_time')->nullable();
            $table->float('travel_km')->nullable();
            $table->unsignedBigInteger("user_id");
            $table->string('status');
            $table->foreign("user_id")->references("id")->on("users");
            $table->unsignedBigInteger("vehicle_id");
            $table->foreign("vehicle_id")->references("id")->on("vehicles");
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
        Schema::dropIfExists('vehicle_historic');
    }
};
