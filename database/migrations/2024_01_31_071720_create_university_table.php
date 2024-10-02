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
        Schema::create('university', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('uni_code');
            $table->string('name');
            $table->string('year');
            $table->string('address');
            $table->string('state');
            $table->string('pincode');
            $table->string('country');
            $table->string('type');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('university');
    }
};
