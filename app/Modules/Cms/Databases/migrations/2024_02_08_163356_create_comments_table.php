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
        Schema::create('base_comments', function (Blueprint $table) {
            $table->id();

            $table->longText('content');
            $table->enum('visibility', ['DRAFT','PRIVATE','PUBLISH'])->default('DRAFT');

            $table->morphs('entity');

            $table->timestamps();
            $table->softDeletes();
            
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('base_users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base_comments');
    }
};
