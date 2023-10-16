<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('matriculation')->nullable();
            $table->string('ramal')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->integer('h_d')->nullable();
            $table->string('motive')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
