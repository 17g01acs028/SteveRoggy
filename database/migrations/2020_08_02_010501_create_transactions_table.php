<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->nullable();
            $table->foreignId('mpesa_code_id')->constrained()->nullable();
            $table->string('TransactionType')->nullable();
            $table->string('TransID')->nullable();
            $table->string('TransTime')->nullable();
            $table->string('TransAmount')->nullable();
            $table->string('BusinessShortCode')->nullable();
            $table->string('BillRefNumber')->nullable();
            $table->string('OrgAccountBalance')->nullable();
            $table->string('MSISDN')->nullable();
            $table->string('FirstName')->nullable();
            $table->string('MiddleName')->nullable();
            $table->string('LastName')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
