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
        Schema::create('base_mediables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id');
            $table->foreign('media_id')->references('id')->on('base_media')->onDelete('restrict');

            $table->morphs('entity');

            $table->string('record_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base_mediables');
    }
};
