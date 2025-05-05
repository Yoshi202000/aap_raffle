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
        Schema::create('prizes', function (Blueprint $table) {
            $table->id('prize_id');
            $table->string('prize_name');
            $table->decimal('prize_value', 10, 2);
            $table->string('prize_image')->nullable();
            $table->unsignedBigInteger('raffle_id');
            $table->timestamps();
            $table->foreign('raffle_id')->references('raffle_id')->on('raffles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prizes', function (Blueprint $table) {
            $table->dropColumn('prize_image');
        });
    }
};
