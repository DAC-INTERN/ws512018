<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('url', function ($t) {
            $t->string('nonAccentTitle');
            $t->text('nonAccentDescription');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('url', function ($t) {
            $t->dropColumn('nonAccentTitle', 'nonAccentDescription');
        });
    }
}
