<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMpesaCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mpesa_codes', function (Blueprint $table) {
            $table->longText('EncrPassword')->nullable()->after('code');
            $table->string('InitUsername')->nullable()->after('code');
            $table->string('CommandID')->nullable()->after('code');
            $table->string('ConsumerKey')->nullable()->after('code');
            $table->string('ConsumerSecret')->nullable()->after('code');
            $table->string('Price')->nullable()->after('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mpesa_codes', function (Blueprint $table) {
            $table->dropColumn('EncrPassword');
            $table->dropColumn('InitUsername');
            $table->dropColumn('CommandID');
            $table->dropColumn('ConsumerKey');
            $table->dropColumn('ConsumerSecret');
            $table->dropColumn('Price');
        });
    }
}
