<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LoginLogout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_logout', function (Blueprint $table) {
            $table->id();
            $table->string('data_login')->nullable();
            $table->string('hora_login')->nullable();
            $table->string('data_logoff')->nullable();
            $table->string('hora_logoff')->nullable();
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
        //
    }
}
