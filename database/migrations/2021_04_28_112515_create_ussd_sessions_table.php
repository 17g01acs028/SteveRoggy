<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUssdSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ussd_sessions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sessionID')->index();
            $table->bigInteger('mobileNumber')->index();
            $table->integer('status')->index();
            $table->string('ussdCode');
            $table->string('url')->nullable();
            $table->text('sessionActivity');
            $table->string('network');
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
        Schema::dropIfExists('ussd_sessions');
    }
}
