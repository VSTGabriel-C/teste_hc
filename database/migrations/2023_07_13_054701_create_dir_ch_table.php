<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirChTable extends Migration
{
    public function up()
    {
        Schema::create('dir_ch', function (Blueprint $table) {
            $table->id();
            $table->string('hour');
            $table->string('km')->nullable();
            $table->integer('warning_ch')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dir_ch');
    }
}
