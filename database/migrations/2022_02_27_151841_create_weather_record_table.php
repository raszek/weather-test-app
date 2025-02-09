<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_record', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable(false);
            $table->string('city')->nullable(false);
            $table->string('country_code')->nullable(false);
            $table->float('temperature')->nullable(false);
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
        Schema::dropIfExists('weather_record');
    }
};
