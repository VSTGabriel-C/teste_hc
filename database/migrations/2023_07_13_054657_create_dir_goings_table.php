<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirGoingsTable extends Migration
{
    public function up()
    {
        Schema::create('dir_goings', function (Blueprint $table) {
            $table->id();
            $table->string('hour');
            $table->string('km')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dir_goings');
    }
}
