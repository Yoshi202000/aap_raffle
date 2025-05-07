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
        Schema::create('aap_raffle', function (Blueprint $table) {
            $table->id('ar_id'); // Primary key, auto-increment

            $table->integer('branch_id')->nullable();
            $table->integer('ar_cat')->nullable();
            $table->integer('ar_members')->nullable();
            $table->integer('ar_attendees')->nullable();
            $table->string('ar_nameprize', 255);
            $table->string('ar_nameprizet', 100)->nullable();
            $table->integer('ar_noprize');
            $table->integer('ar_noattendees')->nullable();
            $table->date('ar_date')->nullable();
            $table->unsignedTinyInteger('ar_order');
            $table->string('raffle_image', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aap_raffle');
    }
};
