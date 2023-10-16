<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('destination')->nullable();
            $table->string('controller_plant')->nullable();
            $table->string('url_route')->nullable();
            $table->unsignedBigInteger('fk_driver');
            $table->foreign('fk_driver')->references('id')->on('drivers')->onDelete('cascade');
            $table->unsignedBigInteger('fk_vehicle');
            $table->foreign('fk_vehicle')->references('id')->on('vehicles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('routes');
    }
}
