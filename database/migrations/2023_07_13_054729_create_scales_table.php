<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateScalesTable extends Migration
{
    public function up()
    {
        Schema::create('scales', function (Blueprint $table) {
            $table->id();
            $table->string('identification');
            $table->timestamp('date_start')->nullable();
            $table->timestamp('hour_start')->nullable();
            $table->timestamp('hour_end')->nullable();
            $table->integer('save');
            $table->integer('active')->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('scales');
    }
}
