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
        Schema::create('user_facility_trans', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('content')->nullable();
            $table->string('title_tmp')->nullable();
            $table->string('contebt_tmp')->nullable();
            $table->string('approved')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_facility_trans');
    }
};
