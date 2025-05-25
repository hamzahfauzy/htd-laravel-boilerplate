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
        Schema::create('base_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->enum('gender', ['MALE','FEMALE'])->nullable();
            $table->string('phone')->nullable();
            $table->json('metadata')->nullable();
            $table->string('record_type')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('base_users')->onDelete('restrict');
            
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('base_users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base_profiles');
    }
};
