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
        Schema::create('bord_of_director', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('qualification');
            $table->string('designation');
            $table->string('status');
            $table->string('doc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bord_of_director');
    }
};
