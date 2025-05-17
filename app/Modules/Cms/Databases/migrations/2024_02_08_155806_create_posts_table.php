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
        Schema::create('base_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('base_posts')->onDelete('restrict');

            $table->string('title');
            $table->string('slug');
            $table->longText('content');
            $table->json('metadata')->nullable();
            $table->string('record_type')->nullable();
            $table->enum('visibility', ['DRAFT','PRIVATE','PUBLISH'])->default('DRAFT');

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
        Schema::dropIfExists('base_posts');
    }
};
