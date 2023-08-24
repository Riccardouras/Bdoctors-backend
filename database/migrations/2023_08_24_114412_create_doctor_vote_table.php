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
        Schema::create('doctor_vote', function (Blueprint $table) {
            $table->id();
            $table->dateTime('rated_at')->default(now());
            $table->timestamps();
            $table->foreignId('doctor_id')->constrained();
            $table->foreignId('vote_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_vote');
    }
};
