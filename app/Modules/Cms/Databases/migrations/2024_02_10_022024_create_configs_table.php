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
        Schema::create('base_configs', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('entity');

            $table->string('label');
            $table->string('code');
            $table->longText('content');
            $table->string('record_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base_configs');
    }
};
