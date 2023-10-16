<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtensilsTable extends Migration
{
    public function up()
    {
        Schema::create('utensils', function (Blueprint $table) {
            $table->id();
            $table->string('oxygen');
            $table->string('obese');
            $table->string('isolate');
            $table->string('stretcher');
            $table->string('isolation');
            $table->string('death');
            $table->string('uti');
            $table->string('d_isolation')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('utensils');
    }
}
