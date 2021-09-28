<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivedMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->nullable();
            $table->foreignId('contact_id')->constrained()->nullable();
            $table->foreignId('short_code_id')->constrained()->nullable();
            $table->float('cost')->nullable();
            $table->string('message',1200)->nullable();
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
        Schema::dropIfExists('received_messages');
    }
}
