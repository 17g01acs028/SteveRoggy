<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->nullable();
            $table->foreignId('user_id')->constrained()->nullable();
            $table->string('source')->nullable();
            $table->string('dest')->nullable();
            $table->string('text',1200)->nullable();
            $table->float('parts')->nullable();
            $table->string('status')->nullable();
            $table->float('cost')->nullable();
            $table->string('route')->nullable();
            $table->string('msgid')->nullable();
            $table->string('error_message')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
