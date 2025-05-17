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
        Schema::create('base_calendars', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description');
            
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            
            $table->string('record_type');

            $table->morphs('entity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base_calendars');
    }
};
