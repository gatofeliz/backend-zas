<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string("event");
            $table->string("description");
            $table->string("timedate");
            $table->string("code");
            $table->string("time_in");
            $table->string("time_out");
            $table->string("hours");
            $table->bigInteger("user_id")->unsigned();

            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users")
            ->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
