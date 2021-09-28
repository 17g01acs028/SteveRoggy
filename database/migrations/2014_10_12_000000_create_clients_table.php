<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('clientName')->unique();
            $table->string('clientAddress');
            $table->string('mobileNo');
            $table->boolean('accType');
            $table->double('accBalance')->nullable();
            $table->double('accLimit')->default(0)->nullable();
            $table->boolean('accStatus')->default(0)->nullable();
            $table->string('httpDlrUrl')->nullable();
            $table->string('dlrHttpMethod')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
