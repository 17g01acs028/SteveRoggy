<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('survey_id');
            $table->foreignId('contact_id');
            $table->foreignId('shortcode_id');
            $table->boolean('exit')->nullable()->default(false);
            $table->date('end_time');
            $table->softDeletes();
            $table->timestamps();
            
        });
        
      ///end

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
