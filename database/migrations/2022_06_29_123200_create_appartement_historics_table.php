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
        Schema::create('appartement_historics', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_time');
            $table->timestamp('expire_date');
            $table->timestamp('end_time');
            $table->string('stay_length');
            $table->string('status');
            $table->unsignedBigInteger('caution');
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('paid_amount');
            $table->unsignedBigInteger('rest');
            $table->unsignedBigInteger('cni_number');
            $table->string('occupant');
            $table->unsignedBigInteger('ca_daily')->nullable();
            $table->unsignedBigInteger('day_amount');
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->unsignedBigInteger("appart_id");
            $table->foreign("appart_id")->references("id")->on("appartements");
            $table->string("contrat_file")->nullable();
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
        Schema::dropIfExists('appartement_historic');
    }
};
