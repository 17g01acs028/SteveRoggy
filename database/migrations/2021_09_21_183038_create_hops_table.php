<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id');
            $table->foreignId('response_id');
            $table->foreignId('contact_id');
            $table->foreignId('survey_id');
            $table->foreignId('client_id');
            $table->softDeletes();
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
        Schema::dropIfExists('hops');
    }
}
