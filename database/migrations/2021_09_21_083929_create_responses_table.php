<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('survey_id');
            $table->string('response');

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('survey_id')->references('id')->on('surveys');
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
        Schema::dropIfExists('responses');
    }
}
