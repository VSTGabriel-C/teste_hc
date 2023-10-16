<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistancePercTable extends Migration
{
    public function up()
    {
        Schema::create('distance_percs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_dir_going')->nullable();
            $table->foreign('fk_dir_going')->references('id')->on('dir_goings')->onDelete('cascade');
            $table->unsignedBigInteger('fk_dir_return')->nullable();
            $table->foreign('fk_dir_return')->references('id')->on('dir_return')->onDelete('cascade');
            $table->unsignedBigInteger('fk_dir_ch')->nullable();
            $table->foreign('fk_dir_ch')->references('id')->on('dir_ch')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('distance_percs');
    }
}
