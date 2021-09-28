<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUssdSessionNavsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ussd_session_navs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mobileNumber')->index();
            $table->bigInteger('sessionID')->index();
            $table->integer('currentLevel')->index();
            $table->integer('nextLevel');
            $table->text('extra')->nullable();
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
        Schema::dropIfExists('ussd_session_navs');
    }
}
