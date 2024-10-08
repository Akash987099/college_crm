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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('description_tmp')->nullable();
            $table->string('title_tmp')->nullable();
            $table->string('approved')->nullable()->default('0');
            $table->string('delete')->nullable()->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
