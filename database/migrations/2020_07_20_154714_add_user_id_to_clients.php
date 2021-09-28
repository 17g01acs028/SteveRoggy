<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
          $table->bigInteger('user_id')->unsigned()->index()->nullable()->after('id');
          $table->foreign('user_id')->references('id')->on('users');
          $table->bigInteger('user_app_id')->unsigned()->index()->nullable()->after('user_id');
          $table->foreign('user_app_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
          $table->dropForeign(['user_app_id']);
          $table->dropColumn('user_app_id');
          $table->dropForeign(['user_id']);
          $table->dropColumn('user_id');
        });
    }
}
