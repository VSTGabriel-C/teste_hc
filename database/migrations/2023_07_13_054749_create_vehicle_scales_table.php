<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleScalesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_scales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_scale');
            $table->foreign('fk_scale')->references('id')->on('scales')->onDelete('cascade');
            $table->unsignedBigInteger('fk_vehicle');
            $table->foreign('fk_vehicle')->references('id')->on('vehicles')->onDelete('cascade');
            $table->unsignedBigInteger('fk_driver');
            $table->foreign('fk_driver')->references('id')->on('drivers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_scales');
    }
}
