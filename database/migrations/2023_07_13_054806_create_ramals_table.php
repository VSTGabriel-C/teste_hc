<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRamalsTable extends Migration
{
    public function up()
    {
        Schema::create('ramals', function (Blueprint $table) {
            $table->id();
            $table->string('n_ramal');
            $table->unsignedBigInteger('fk_applicant')->nullable();
            $table->foreign('fk_applicant')->references('id')->on('applicants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ramals');
    }
}
