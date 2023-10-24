<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginLogoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_logouts', function (Blueprint $table) {
            $table->id();
            $table->string('date_login')->nullable();
            $table->string('hour_login')->nullable();
            $table->string('date_logoff')->nullable();
            $table->string('hour_logoff')->nullable();
            $table->unsignedBigInteger('fk_in_off');
            $table->foreign('fk_in_off')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_logouts');
    }
}
