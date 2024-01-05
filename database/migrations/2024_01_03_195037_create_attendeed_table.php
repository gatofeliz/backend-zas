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
        Schema::create('attendeed', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->boolean("confirmated")->default(false);
            $table->bigInteger("event_id")->unsigned();
            $table->bigInteger("gift_id")->unsigned()->default(0);
            
            $table->foreign("event_id")->references("id")->on("events")
            ->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("gift_id")->references("id")->on("gifts")
            ->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendeed');
    }
};
