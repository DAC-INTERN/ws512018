<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStringSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StringSearch', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Search_String');
            $table->boolean('duplicate');
            $table->string('browser');
            $table->string('device');
            $table->string('IP');
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
        Schema::dropIfExists('StringSearch');
    }
}
