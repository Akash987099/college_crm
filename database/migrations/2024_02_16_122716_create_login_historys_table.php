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
        Schema::create('login_historys', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('login_time')->nullable();
            $table->string('logout_time')->nullable();
            $table->string('duration')->nullable();
            $table->string('duration_time')->nullable();
            $table->string('total_duration')->nullable();
            $table->string('total_duration_time')->nullable();
            $table->string('logout')->nullable();
            $table->string('date')->date();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_historys');
    }
};
