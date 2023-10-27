<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitationsTable extends Migration
{
    public function up()
    {
        Schema::create('solicitations', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('hour');
            $table->string('destiny');
            $table->string('ordinance');
            $table->string('end_loc_ident');
            $table->string('going')->nullable();
            $table->string('return')->nullable();
            $table->string('cancellation')->nullable()->default('NOK');
            $table->string('n_file');
            $table->string('hc')->nullable();
            $table->string('incor')->nullable();
            $table->string('radio')->nullable();
            $table->string('contact_plant')->nullable();
            $table->string('attendance_by')->nullable();
            $table->string('observation')->nullable();
            $table->string('status_sol')->nullable();
            $table->unsignedBigInteger('fk_user')->nullable();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('fk_ramal')->nullable();
            $table->foreign('fk_ramal')->references('id')->on('ramals')->onDelete('cascade');
            $table->unsignedBigInteger('fk_applicant')->nullable();
            $table->foreign('fk_applicant')->references('id')->on('applicants')->onDelete('cascade');
            $table->unsignedBigInteger('fk_utensil')->nullable();
            $table->foreign('fk_utensil')->references('id')->on('utensils')->onDelete('cascade');
            $table->unsignedBigInteger('fk_vehicle')->nullable();
            $table->foreign('fk_vehicle')->references('id')->on('vehicles')->onDelete('cascade');
            $table->unsignedBigInteger('fk_driver')->nullable();
            $table->foreign('fk_driver')->references('id')->on('drivers')->onDelete('cascade');
            $table->unsignedBigInteger('fk_dist_perc')->nullable();
            $table->foreign('fk_dist_perc')->references('id')->on('distance_percs')->onDelete('cascade');
            $table->unsignedBigInteger('fk_patient')->nullable();
            $table->foreign('fk_patient')->references('id')->on('patients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitations');
    }
}
